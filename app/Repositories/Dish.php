<?php

namespace App\Repositories;
use Illuminate\Http\Request;

use Image;
use App\Models\Dish as DishModel;

class Dish extends BaseRepository
{
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(DishModel $model)
    {
        $this->model = $model;
    }
    

    /**
     * Create a new user
     *
     * @param  Request $request [description]
     * @return User
     */
    public function store ($request, $userId) : DishModel
    {
        return DishModel::create([
            'name'         => $request->name,
            'price'        => $request->price,
            'serves'       => $request->serves,
            'user_id'      => $userId,
            'duration'     => $request->duration,
            'cuisine_id'   => $request->cuisine_id,
            'ingredients'  => $request->ingredients,
            'description'  => $request->description
        ]);
    }


    /**
     * Update a user 
     * 
     * @param User $user 
     * @param Request $request
     * @return User
     */
    public function update (DishModel $dish, $request)
    { 
        $dish->name         = $request->name;
        $dish->price        = $request->price;
        $dish->serves       = $request->serves;
        $dish->duration     = $request->duration;
        $dish->cuisine_id   = $request->cuisine_id;
        $dish->cuisine_id   = $request->cuisine_id;
        $dish->ingredients  = $request->ingredients;
        $dish->description  = $request->description;

        $dish->save();
        return $dish;
    }


    public function userDishByCode (int $userId, string $dishCode)
    {
        return DishModel::where('code', $dishCode)
            ->where('user_id', $userId)
            ->first();
    }


    /**
     * Filter users 
     * 
     * @return Collection 
     */
    public function filter (array $params)
    {
        $paginate = \Arr::get($params, 'paginate', 10);

        return DishModel::with('cuisine')
            ->when(isset($params['keywords']), function ($q) use ($params) {
                return $q->where( function ($query) use ($params) {
                    return $query->where('name', 'like', '%' . $params['keywords'] . '%');
                });
            })
            ->orderBy('name', 'asc')
            ->paginate($paginate);
    }

    /**
     * Upload base64 Image to user profile
     *
     * @param  UserModel $user
     * @param  String    $base64String
     * @return
     */
    public function saveImage (DishModel $dish, $base64String)
    {
        if ($base64String) {
            $image_parts = explode(";base64,", $base64String);
            $decoded = base64_decode($image_parts[1]);

            $time = time();
            $fileName  = 'dish-' . $dish->code . '-' . $time . '.jpg';
            $thumbName = 'dish-' . $dish->code . '-' . $time . '-thumbnail' .'.jpg';

            $img = Image::make($decoded);

            // Max file width 500px
            $data = (string) $img->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 90);

            \Storage::put('yummooh/' . $fileName, $data, 'public');

            // Thumbnail max with 150px
            $data = (string) $img->fit(150, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 90);

            \Storage::put('yummooh/' . $thumbName, $data, 'public');

            $dish->photo = 'yummooh/' . $fileName;
            $dish->thumbnail = 'yummooh/' . $thumbName;
            $dish->save();
        }

        return $dish;
    }
}
