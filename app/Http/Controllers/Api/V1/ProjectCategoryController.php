<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCategoryRequest;
use App\Repositories\ProjectCategoryRepository;
use App\Http\Resources\ProjectCategory as ProjectCategoryResource;
use App\Http\Resources\ProjectCategoryCollection as ProjectCategoryCollectionResource;


class ProjectCategoryController extends Controller
{
    /**
     * @var ProjectCategoryRepository $projectCategoryRepository
     */
    protected $projectCategoryRepository;

    /**
     * ProjectCategoryController constructor.
     *
     * @param ProjectCategoryRepository $projectCategoryRepository
     */
    public function __construct(ProjectCategoryRepository $projectCategoryRepository)
    {
        $this->projectCategoryRepository = $projectCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->projectCategoryRepository->getByOrganization(request()->organization->id);
        return new ProjectCategoryCollectionResource($projects);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectCategoryRequest $request)
    {

        try
        {
            $organization = request()->organization;
            $exists = $organization->projectCategories()
            ->where('name', $request->name)->first();

            // Category name has to be unique per organization
            if ($exists) {
                return response()->json(['message' => 'Project category already exists'], self::HTTP_BADREQUEST);
            }

            $saved = $this->projectCategoryRepository->store([
                'name'            => $request->name,
                'organization_id' => $organization->id
            ]);

            if ($saved) {
                return response()->json($saved);
            } else {
                return response()->json(['message'=>'error occurred while creating of a project category'],400);
            }
        } catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'], self::HTTP_ERROR);
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
        $projectCategory = $this->projectCategoryRepository->getById($id);

        if(is_null($projectCategory) ) {
            return abort(404);
        }
        return  new ProjectCategoryResource($projectCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectCategoryRequest $request, $id)
    {

        try
        {
            $organization = request()->organization;
            $exists = $organization->projectCategories()
            ->where('name', $request->name)->first();

            $projectCategory = $this->projectCategoryRepository->getById($id);

            if ($exists) {
                if ($projectCategory->id !== $exists->id)
                return response()->json(['message' => 'Project category already exists'], self::HTTP_BADREQUEST);
            }


            if (!$projectCategory) return response()->json(['message' => 'Project category does not exist'], self::HTTP_BADREQUEST);

            $updated = $this->projectCategoryRepository->update($projectCategory->id, $request->only(['name']));
            return response()->json($updated);

        } catch (\Exception $e) {
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
            $projectCategory = $this->projectCategoryRepository->getById($id);

            // Cannot delete a category with projects
            if ($projectCategory->projects()->count()) {
                return response()->json([
                    'message' => 'A category with projects cannot be deleted'
                ], self::HTTP_BADREQUEST);
            }

            $delete = $this->projectCategoryRepository->delete($id);
            if ($delete) {
                return response()->json(['message'=>'the project category has been deleted'],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

}
