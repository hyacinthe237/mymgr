<?php

namespace App\Http\Controllers\Api\Mobile;

use Illuminate\Support\Facades\Validator;
use App\Repositories\Dish as DishRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Store a dish
     * 
     * @return Json 
     */
    public function store (Request $request, DishRepo $dishRepo)
    {
        try 
        {
            $rules = [
                'name'        => 'required',
                'price'       => 'required',
                'serves'      => 'required',
                'duration'    => 'required',
                'cuisine_id'  => 'required',
                'ingredients' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);

            $user = $request->user();
            $dish = $dishRepo->store($request, $user->id);

            if ($dish)
                $user->cuisines()->attach($dish->cuisine);
            
            return response()->json($dish);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Update a dish
     * 
     * @return Json 
     */
    public function update (Request $request, DishRepo $dishRepo, string $code)
    {
        try 
        {
            $rules = [
                'name'        => 'required',
                'price'       => 'required',
                'serves'      => 'required',
                'duration'    => 'required',
                'cuisine_id'  => 'required',
                'ingredients' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);

            $user = $request->user();
            $dish = $dishRepo->userDishByCode($user->id, $code);

            if (!$dish)
                return response()->json('No matching dish found', self::HTTP_FORBIDDEN);

            $dish = $dishRepo->update($dish, $request);
            return response()->json($dish);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Save dish image 
     * 
     * @return Json 
     */
    public function saveImage (Request $request, DishRepo $dishRepo, string $code)
    {
        try 
        {
            $user = $request->user();
            $dish = $dishRepo->userDishByCode($user->id, $code);

            if (!$dish)
                return response()->json('No matching dish found', self::HTTP_FORBIDDEN);
                
            $dish = $dishRepo->saveImage($dish, $request->image);
            return response()->json($dish);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
