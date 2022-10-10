<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectCategory extends Model
{
     use SoftDeletes, Uuids;

     /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_categories';

	/**
	* primary key
	*/
	protected $primaryKey = "id";

    public function projects () {
        return $this->hasMany("App\Models\Project", 'category_id');
    }
    public function organization() {
       return $this->belongsTo("App\Models\Organization", 'organization_id');
    }


    public function __construct(array $attributes = array()) {
       parent::__construct($attributes);
    }
}
