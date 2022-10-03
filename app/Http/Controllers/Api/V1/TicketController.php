<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Repositories\TicketRepository;
use App\Http\Resources\TicketResourceCollection;

class TicketController extends Controller
{
    public $repo; 


    public function __construct (TicketRepository $repo)
    {
        $this->repo = $repo;
    }


    /**
     * Get user tickets 
     * 
     * @return Collection 
     */
    public function index (Request $request) 
    {
        try 
        {
            $tickets = $this->repo->filter($request->all());
            $collection = new TicketResourceCollection($tickets);

            return response()->json($collection);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Update model  
     * 
     * @return App\Models\Ticket
     */
    public function show ($code)
    {
        try 
        {
            $model = $this->repo->findModelByCode($code);
            $model = new TicketResource($model);
            
            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Update model  
     * 
     * @return App\Models\Ticket
     */
    public function update (Request $request, $code)
    {
        try 
        {
            $model = $this->repo->findModelByCode($code);
            $user  = $request->user();
            $request->updated_by = $user->id;

            $model = $this->repo->updateTicket($model, $request);
            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
