<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use App\Repositories\OrganizationRepository;
use App\Http\Resources\Organization as OrganizationResource;
use App\Http\Resources\OrganizationCollection as OrganizationCollectionResource;

class OrganizationController extends Controller
{

    /**
     * @var OrganizationRepository $organizationRepository
     */
    protected $organizationRepository;

    /**
     * OrganizationController constructor.
     *
     * @param OrganizationRepository $organizationRepository
     */
    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->organizationRepository->pushCriteria(app('App\Repositories\Criteria\RequestCriteria'));
        $organizations = $this->organizationRepository->all();
        return  new OrganizationCollectionResource($organizations);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRequest $request)
    {
        $input = $request->all();
        $admin = $request->user();
        $input['admin_id'] = $admin->id;
        try {
            $organization = $this->organizationRepository->store($input);
            if ($organization) {
                return response()->json($organization);
            }else{
                return response()->json([
                'message'=>'error occurred while creating of an organization'
                ], self::HTTP_BADREQUEST);
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
    public function show($id)
    {
        $organization = $this->organizationRepository->getById($id);

        if(is_null($organization) ) {
            return abort(404);
        }
        return  new OrganizationResource($organization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationRequest $request, $id)
    {
        $input = $request->all();
        try {
            $organization = $this->organizationRepository->getById($id);
            $updated = $this->organizationRepository->update($organization->id,$input);
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
            $delete = $this->organizationRepository->delete($id);
            if($delete){
                return response()->json(['message'=>'the organization has been deleted'],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

}
