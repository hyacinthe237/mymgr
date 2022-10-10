<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
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
    protected $table = 'comments';

	/**
	* primary key
	*/
	protected $primaryKey = "id";


    /**
     * Get all of the owning commentable models.
     */
    public function commentable(){
        return $this->morphTo();
    }

    public function owner() {
       return $this->belongsTo("App\Models\User",'created_by');
    }
}
