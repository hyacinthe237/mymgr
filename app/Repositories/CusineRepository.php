<?php 

namespace App\Repositories;

use Arr;
use App\Models\Cuisine;
use Illuminate\Http\Request;


class CusineRepository extends BaseRepository
{
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(Cuisine $model)
    {
        $this->model = $model;
    }


    /**
     * Filter users 
     * 
     * @return Collection 
     */
    public function filter (array $params)
    {
        $paginate = Arr::get($params, 'paginate', 10);

        return Cuisine::when(isset($params['keywords']), function ($q) use ($params) {
                return $q->where( function ($query) use ($params) {
                    return $query->where('name', 'like', '%' . $params['keywords'] . '%');
                });
            })
            ->orderBy('name', 'asc')
            ->paginate($paginate);
    }



    /**
     * Update a user 
     * 
     * @param User $user 
     * @param Request $request
     * @return User
     */
    public function update (Cuisine $model, $request)
    { 
        $model->name         = $request->name;
        $model->cover        = $request->cover;

        $model->save();

        return $model;
    }


    /**
     * Create a cuisine
     * 
     * @param Request $request
     * @return Cuisine
     */
    public function createCuisine (Request $request)
    {
        return Cuisine::create([
            'name'         => $request->name,
            'cover'        => $request->cover
        ]);
    }
}