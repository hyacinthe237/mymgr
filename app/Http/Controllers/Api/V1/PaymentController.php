<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\PaymentResourceCollection;
use App\Http\Resources\PaymentResource;
use App\Repositories\EarningRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public $repo; 


    public function __construct (EarningRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get payments
     * 
     * @return Collection 
     */
    public function index (Request $request) 
    {
        try 
        {
            $models = $this->repo->filter($request->all());
            $collection = new PaymentResourceCollection($models);

            return response()->json($collection);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * GEt single payment
     * 
     * @return App\Models\Ticket
     */
    public function show ($code)
    {
        try 
        {
            $model = $this->repo->findModelByCode($code);
            $model = new PaymentResource($model);
            
            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

}
