<?php

namespace App\Http\Controllers\Views\Frontend;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TicketRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ProjectCategoryRepository;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectCollectiion as ProjectCollectiionResource;

class ProjectController extends Controller
{

    /**
     * @var ProjectRepository $projectRepository
     * @var projectCategoryRepository $projectCategoryRepository
     */
    protected $projectRepository;
    protected $projectCategoryRepository;

    /**
     * ProjectController constructor.
     *
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository, ProjectCategoryRepository $projectCategoryRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->projectCategoryRepository = $projectCategoryRepository;
    }

    /**
     * Display the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('frontend.projects.index');
    }

    /**
     * Display the details page.
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {

        return view('frontend.projects.show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $projects = $this->ProjectRepository->all();
        return  new ProjectCollectiionResource($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $this->validator($input)->validate();
        $connectedUser = Auth::user();
        try {
            $saved = $this->projectRepository->store($input);
            if($saved && isset($saved->id)){
                return response()->json(['id'=>$saved->id],201);
            }else{
                return response()->json(['message'=>'error occurred while creating of a project'],400);
            }
        } catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $project = $this->projectRepository->getByCode($code);

        if(is_null($project) ) {
            return abort(404);
        }

        if (Auth::user()->cant('view', $project)) {
            abort(404);
        }

        return view('frontend.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $organization = session('organization');
        $project = $this->projectRepository->getByCode($code);

        if( is_null($project) ) {
            return abort(404);
        }

        $connected = Auth::user();
        $users = $project->organization->users;
        $categories = $this->projectCategoryRepository->getByOrganization($organization->id);
        $project->files;

        return view("frontend.projects.edit", [
            "project" => $project,
            "users" => $users,
            "categories" => $categories,
            "connected" => $connected
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $this->validator($input)->validate();
        try {
            $project = $this->projectRepository->getById($id);
            $updated = $this->projectRepository->update($project->id,$input);
            if($updated && isset($updated->id)){
                return response()->json(['id'=>$updated->id],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'owner_id' => 'required|integer',
            'organization_id' => 'required|integer',
            'category_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'string|max:255',
            'goals' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_public' => 'required|boolean',
        ]);
    }



    /**
     * Show project tickets
     */
    public function tickets (TicketRepository $ticketRepo, $code)
    {
        $project = $this->projectRepository->getByCode($code);
        $organization = session('organization');
        $users = $project->organization->users;

        if( !$project ) return abort(404);
        if (Auth::user()->cant('view', $project)) abort(404);

        $tickets = $ticketRepo->allByProject($project)->where('is_open', true);
        //dd($tickets);

        return view('frontend.projects.tickets', compact('project', 'tickets', 'users'));
    }

    /**
     * Show project stats
     */
    public function stats (TicketRepository $ticketRepo, $code)
    {
        $project = $this->projectRepository->getByCode($code);

        if( !$project ) return abort(404);
        if (Auth::user()->cant('view', $project)) abort(404);

        $stats = $ticketRepo->ticketStatisticsByProject($project);
        //dd($stats);

        return view('frontend.projects.stats', compact('project', 'stats'));
    }
}
