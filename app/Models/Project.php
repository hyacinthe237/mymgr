<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
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
    protected $table = 'projects';

	/**
	* primary key
	*/
	protected $primaryKey = "id";


    public function tickets(){
        return $this->hasMany("App\Models\Ticket", 'project_id');
    }

    public function owner() {
       return $this->belongsTo("App\Models\User",'owner_id');
    }

    public function users () {
        return $this->belongsToMany('App\Models\User', 'project_users');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User','created_by');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\ProjectCategory', 'category_id');
    }

    public function organization() {
       return $this->belongsTo("App\Models\Organization", 'organization_id');
    }

    public function files () {
        return $this->morphMany(File::class, 'fileable');
    }

    public function comments(){
        return $this->morphMany('App\Models\Comment', 'commentable');
    }


    public function __construct(array $attributes = array()) {
       parent::__construct($attributes);
    }
}
