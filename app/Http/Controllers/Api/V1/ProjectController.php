<?php

namespace App\Http\Controllers\Api\V1;

use DB;
use Auth;
use Validator;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\CommentRequest;
use App\Repositories\ProjectRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\CommentRepository;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectCollection as ProjectCollectionResource;
use App\Http\Resources\CommentCollection as CommentCollectionResource;

class ProjectController extends Controller
{

    /**
     * @var ProjectRepository $projectRepository
     */
    protected $projectRepository;

    /**
     * @var CommentRepository $commentRepository
     */
    protected $commentRepository;

    /**
     * @var FileRepository $fileRepository
     */
    protected $fileRepository;

    /**
     * ProjectController constructor.
     *
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository,
            CommentRepository $commentRepository, FileRepository $fileRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->commentRepository = $commentRepository;
        $this->fileRepository    = $fileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrganizationRepository $orgRepo, Request $request)
    {
        $user = Auth::user();
        $code = $request->header('organization');
        $organization = $orgRepo->getByCode($code);
        $allProjects = $this->projectRepository->allByOrganization($organization);
        $projects = $this->projectRepository->allByOrganization($organization)->where('is_public', true);
        $privateProjects = $this->projectRepository->allByOrganization($organization)->where('is_public', false);

        if($organization->admin_id === $user->id) {
            $projects = $allProjects;
        } else {
            foreach ($privateProjects as $item) {
                $privateUsers = DB::table('project_users')->where('project_id', $item->id)->get();
                foreach ($privateUsers as $p) {
                    if ($p->user_id === $user->id) {
                        $projects[] = $item;
                    }
                }
            }
        }

        return  new ProjectCollectionResource($projects);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRepository $orgRepo, ProjectRequest $request)
    {
        try {
            $code = $request->header('organization');
            $organization = $orgRepo->getByCode($code);

            $saved = $this->projectRepository->store([
                'title' => $request->title,
                'owner_id' => $request->user()->id,
                'created_by' => $request->user()->id,
                'organization_id' => $organization->id,
                'category_id'   => $organization->projectCategories()->first()->id
            ]);

            if ($saved){
                return response()->json($saved);
            } else {
                return response()->json(['message'=>'error occurred while creating of a project'],400);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = $this->projectRepository->getById($id);

        if(is_null($project) ) {
            return abort(404);
        }

        return  new ProjectResource($project);
    }

    public function getPrivateUsers($code)
    {
        $project = Project::where('code', $code)->firstOrFail();

        if (!($project->is_public)) {
            $usersId = DB::table('project_users')->where('project_id', $project->id)->get();

            $usersTab = [];
            $index = 0;
            foreach ($usersId as $item) {
                $index++;
                $usersTab[$index] = User::where('status', 'active')->where('id', $item->user_id)->first();
            }

            return response()->json($usersTab);
        }
    }

    public function getNotPrivateUsers($code)
    {
        $project = Project::where('code', $code)->firstOrFail();

        if (!($project->is_public)) {
            $usersId = DB::table('project_users')->where('project_id', $project->id)->get();
            $usersPublic = $project->organization->users;

            $usersTab = [];
            $index = 0;

            foreach ($usersPublic as $item) {
                foreach ($usersId as $itemId) {
                    if ($itemId->user_id == $item->id) {
                        unset($usersPublic[$index]);
                    }
                }
                $index++;
            }

            return response()->json($usersPublic);
        }
    }

    public function removePrivateUsers(Request $request)
    {
        $input = $request->only(['id', 'project_id']);

        try {
            $projectUser = DB::table('project_users')
            ->where('project_id', $input['project_id'])
            ->where('user_id', $input['id'])->delete();
            if($projectUser)
                return response()->json(['message'=>'The user has been successfully removed'], 200);

        } catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }

    }

    /**
     * Add user to private project
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addPrivate(Request $request)
    {
        $project = Project::whereCode($request->code)->where('is_public',false)->first();

        if ( !$project )
            return response()->json(['message'=>'Project not found'], 404);

        $project->users()->attach($request->user_id);

        return response()->json(['message'=>'Operation successful'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $code)
    {
        $input = $request->only([
            'category_id', 'description', 'end_date', 'goal', 'is_public',
            'organization_id', 'owner_id', 'start_date', 'status', 'title','slack_channel'
        ]);

        try
        {
            $project = $this->projectRepository->getByCode($code);
            $updated = $this->projectRepository->update($project->id, $input);

            if ($updated) {
                return response()->json($updated);
            }
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

     /**
     * add comment on the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addComment(CommentRequest $request, $id)
    {
        $input = $request->except(['organization']);

        try
        {
            $project = $this->projectRepository->getById($id);
            $input['commentable_id'] = $project->id;
            $input['commentable_type'] = get_class($project);
            $input['created_by'] = $request->user()->id;
            $comment = $this->commentRepository->store($input);


            if ($comment) {
                return response()->json($comment);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

    /**
     * Removing a file by Code
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function removeFile($code, $file_code) {

        $project = $this->projectRepository->getByCode($code);

        if ( !$project )
            return response()->json(['message'=>'Project not found'], 404);

        $file = $this->fileRepository->getByCode($file_code);

        if ( !$file )
            return response()->json(['message'=>'File not found'], 404);

        // Delete file record
        $this->fileRepository->delete($file->id);

        // Delete file
        Storage::delete($file->link);

        return response()->json(['message'=>'This file as been successfully deleted'], 200);
    }

    /**
     * remove comment on the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function removeComment($code)
    {
       $comment = $this->commentRepository->delete($code);
       return response()->json(['message'=>'This comment has been successfully deleted'], self::HTTP_SUCCESS);

    }


    /**
     * list comment on the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listComments($id)
    {
        $user = Auth::user();
        $comments = $this->commentRepository->getByProjectId($id);
        return  new CommentCollectionResource($comments);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = $this->projectRepository->delete($id);
            if($delete){
                return response()->json(['message'=>'the project has been deleted'],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }


    /**
     * Show all project tickets
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function tickets ($code)
    {
        try
        {
            $project = $this->projectRepository->getByCode($code);

            if (!$project) {
                return response()->json(['message' => 'No project found'], self::HTTP_FORBIDDEN);
            }

            $tickets = $project->tickets()
                ->with('category', 'assignee', 'project')
                ->where('is_open', true)
                ->orderBy('id', 'desc')
                ->get();

            return response()->json(['items' => $tickets]);
        }
        catch (Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

}
