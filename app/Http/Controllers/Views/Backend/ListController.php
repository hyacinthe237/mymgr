<?php

namespace App\Http\Controllers\Views\Backend;

use App\Repositories\Dish as DishRepository;
use App\Repositories\CusineRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListController extends Controller
{

    public function cuisines (CusineRepository $repo, Request $request)
    {
        $model = $repo->all($request);
        return view('backend.lists.cuisines', ['cuisines' => $model]);
    }


    public function cuisine (CusineRepository $repo, string $code)
    {
        $model = $repo->findModelByCode($code);
        if (!$model) abort(404);
        
        return view('backend.lists.cuisine', ['cuisine' => $model]);
    }


    public function cuisineCreate (CusineRepository $repo)
    {
        return view('backend.lists.cuisine-create');
    }


    public function dishes (DishRepository $repo, Request $request)
    {
        $model = $repo->all($request);
        return view('backend.lists.dishes', ['dishes' => $model]);
    }

    public function dish (DishRepository $repo, string $code)
    {
        $model = $repo->findModelByCode($code);
        if (!$model) abort(404);

        return view('backend.lists.dish', ['dish' => $model]);
    }
}
