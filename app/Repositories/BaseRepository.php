<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository
{
    /**
     * @var Model 
     */
    protected $model;

    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all ()
    {
        return $this->model->all();
    }


    public function createModel (array $payload) 
    {
        return $this->model->create($payload);
    }


    public function findModel (int $id) 
    {
        return $this->model->find($id);
    }
    
    
    public function findModelByKey (string $key, string $value)
    {
        return $this->model->where($key, $value)->first();
    }

    public function findModelByCode(string $code)
    {
        return $this->findModelByKey('code', $code);
    }

    public function updateModel (Model $model, array $payload)
    {
        $model->update($payload);
        return $model->fresh();
    }


    public function deleteModel (Model $model)
    {
        return $model->delete();
    }
}