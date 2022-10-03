<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Resources\ChefResourceCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuisine;

class CuisineController extends Controller
{
    public function index (Request $request)
    {
        try 
        {
            $cuisines = Cuisine::get();
            return response()->json($cuisines);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    public function show ($code)
    {
        try 
        {
            $cuisine = Cuisine::whereCode($code)->firstOrFail();
            return response()->json($cuisine);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    public function chefs ($code)
    {
        try 
        {
            $paginate = 10;

            $cuisine = Cuisine::whereCode($code)->firstOrFail();

            $chefs = $cuisine->users()
                ->where('status', '=', 'active')
                ->orderBy('ratings', 'desc')
                ->distinct()
                ->paginate($paginate);

            return new ChefResourceCollection($chefs);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
