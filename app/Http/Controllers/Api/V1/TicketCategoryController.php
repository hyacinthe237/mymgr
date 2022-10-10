<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCategoryRequest;
use App\Repositories\TicketCategoryRepository;
use App\Http\Resources\TicketCategory as TicketCategoryResource;
use App\Http\Resources\TicketCategoryCollection as TicketCategoryCollectionResource;

class TicketCategoryController extends Controller
{
    /**
     * @var TicketCategoryRepository $ticketCategoryRepository
     */
    protected $ticketCategoryRepository;

    /**
     * TicketCategoryController constructor.
     *
     * @param TicketCategoryRepository $ticketCategoryRepository
     */
    public function __construct(TicketCategoryRepository $ticketCategoryRepository)
    {
        $this->ticketCategoryRepository = $ticketCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticketCategories = $this->ticketCategoryRepository->getByOrganization(request()->organization->id);
        return  new TicketCategoryCollectionResource($ticketCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketCategoryRequest $request)
    {
       try
        {
            $organization = request()->organization;
            $exists = $organization->ticketCategories()
            ->where('name', $request->name)->first();

            // Category name has to be unique per organization
            if ($exists) {
                return response()->json(['message' => 'Ticket category already exists'], self::HTTP_BADREQUEST);
            }

            $saved = $this->ticketCategoryRepository->store([
                'name'            => $request->name,
                'organization_id' => $organization->id
            ]);

            if ($saved) {
                return response()->json($saved);
            } else {
                return response()->json(['message'=>'error occurred while creating of a ticket category'],400);
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
        $ticketCategory = $this->ticketCategoryRepository->getById($id);

        if(is_null($ticketCategory) ) {
            return abort(404);
        }
        return  new TicketCategoryResource($ticketCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketCategoryRequest $request, $id)
    {
        try
        {
            $organization = request()->organization;
            $exists = $organization->ticketCategories()
            ->where('name', $request->name)->first();

            $ticketCategory = $this->ticketCategoryRepository->getById($id);

            if ($exists) {
                if ($ticketCategory->id !== $exists->id)
                return response()->json(['message' => 'Ticket category already exists'], self::HTTP_BADREQUEST);
            }


            if (!$ticketCategory) return response()->json(['message' => 'Ticket category does not exist'], self::HTTP_BADREQUEST);

            $updated = $this->ticketCategoryRepository->update($ticketCategory->id, $request->only(['name']));
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
            $ticketCategory = $this->ticketCategoryRepository->getById($id);
            // Cannot delete a category with ticket
            if ($ticketCategory->tickets()->count()) {
                return response()->json([
                    'message' => 'A category with ticket cannot be deleted'
                ], self::HTTP_BADREQUEST);
            }
            $delete = $this->ticketCategoryRepository->delete($id);
            if($delete){
                return response()->json(['message'=>'the ticket category has been deleted'],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

}
