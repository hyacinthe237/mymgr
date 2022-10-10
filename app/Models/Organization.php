<?php

namespace App\Models;

use Auth;
use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
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
    protected $table = 'organizations';

	/**
	* primary key
	*/
	protected $primaryKey = "id";


    public function users(){
        return $this->belongsToMany(User::class,'user_organizations')
                ->withPivot('position')
                ->withTimestamps();
    }

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }


    public function __construct(array $attributes = array()) {
       parent::__construct($attributes);
    }


    public function isActive () {
        return $this->status === 'active';
    }


    public function projectCategories() {
        return $this->hasMany(ProjectCategory::class);
    }

    public function ticketCategories() {
        return $this->hasMany(TicketCategory::class);
    }

    public function invitations() {
        return $this->hasMany(Invitation::class);
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function tickets() {
        return $this->hasManyThrough(Ticket::class, Project::class, 'organization_id', 'project_id', 'id');
    }

    /**
     * Set the Organization's admin_id.
     *
     * @param  integer  $value
     * @return void
     */
    /*public function setAdminIdAttribute($value)
    {
        if (Auth::user()) {
            $this->attributes['admin_id'] = Auth::user()->id;
        }
    }*/
}
