<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CusineRepository;
use App\Repositories\Dish as DishRepository;

class ListController extends Controller
{
    /**
     * List cuisines 
     */
    public function cuisines (Request $request)
    {
        try 
        {
            $repository = resolve(CusineRepository::class);
            $models = $repository->filter($request->all());

            return response()->json($models);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     *  Get a cuisine
     */
    public function cuisine (string $code)
    {
        try 
        {
            $repository = resolve(CusineRepository::class);
            $model = $repository->findModelByCode($code);

            $model->cover = str_contains($model->cover, 'http') 
                ? $model->cover
                : \Storage::url($model->cover);

            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     *  Create a cuisine
     */
    public function cuisineCreate (Request $request)
    {
        try 
        {
            $repository = resolve(CusineRepository::class);
            $model = $repository->createCuisine($request);

            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     *  Update a cuisine
     */
    public function cuisineUpdate (Request $request, string $code)
    {
        try 
        {
            $repository = resolve(CusineRepository::class);
            $model = $repository->findModelByCode($code);
            $model = $repository->update($model, $request);

            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * List Dishes 
     */
    public function dishes (Request $request)
    {
        try 
        {
            $repository = resolve(DishRepository::class);
            $models = $repository->filter($request->all());

            return response()->json($models);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     *  Get a cuisine
     */
    public function dish (string $code)
    {
        try 
        {
            $repository = resolve(DishRepository::class);
            $model = $repository->findModelByCode($code);

            if (!$model) response()->json('NOT FOUND', self::HTTP_NOTFOUND);

            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     *  Update a cuisine
     */
    public function dishUpdate (Request $request, string $code)
    {
        try 
        {
            $repository = resolve(DishRepository::class);
            $model = $repository->findModelByCode($code);
            $model = $repository->update($model, $request);

            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     *  Update a cuisine
     */
    public function dishUpdateImage (Request $request, string $code)
    {
        try 
        {
            $repository = resolve(DishRepository::class);
            $model = $repository->findModelByCode($code);
            $model = $repository->saveImage($model, $request->image);

            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
