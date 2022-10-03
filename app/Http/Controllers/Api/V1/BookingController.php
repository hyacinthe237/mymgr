<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Repositories\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingResourceCollection;

class BookingController extends Controller
{
    public $repo; 


    public function __construct (Booking $repo)
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
        $bookings = $this->repo->filter($request->all());
            $collection = new BookingResourceCollection($bookings);

            return response()->json($collection);
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
            $model = new BookingResource($model);
            
            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
