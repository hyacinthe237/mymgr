<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use App\Utilities\Uuids;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable, Notifiable, SoftDeletes, Uuids;

    protected $guarded = ['id'];

    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'json'  => 'array'
    ];


     /**
     * Update a user bank details
     * 
     * @param Array $req 
     * @return void 
     */
    public function updateBankDetails (object $req) : void 
    {
        $this->bank_bsb             = $req->bank_bsb;
        $this->bank_name            = $req->bank_name;
        $this->bank_account_holder  = $req->bank_account_holder;
        $this->bank_account_number  = $req->bank_account_number;

        $this->save();
    }

    /**
     * Get chef cuisines 
     * 
     * @return Collection $cuisines
     */
    public function cuisines () 
    {
        return $this->belongsToMany(Cuisine::class);
    }

    /**
     * Get chef cuisines 
     * 
     * @return Collection $cuisines
     */
    public function dishes () 
    {
        return $this->hasMany(Dish::class);
    }


    /**
     * Get user role
     * 
     * @return Role $role
     */
    public function role () 
    {
        return $this->belongsTo(Role::class);
    }


    /**
     * Get documents 
     * 
     * @return Collection 
     */
    public function documents () 
    {
        return $this->belongsToMany(Document::class, 'user_documents')
            ->withPivot('status', 'link');
    }


    /**
     * Get active users 
     * 
     * @return Eloquent
     */
    public function scopeIsActive ($query)
    {
        return $query->where('status', '=', 'active');
    }


    /**
     * Get users of type chefs
     * 
     * @return Eloquent
     */
    public function scopeIsChef ($query)
    {
        return $query->where('role_id', '=', 2);
    }


    public function isAdmin () 
    {
        return $this->role_id === 1;
    }

    /**
     * Get profile photo 
     * 
     * @return string
     */
    public function getProfileAttribute()
    {
        if ($this->attributes['profile']) {
            if (\Str::startsWith($this->attributes['profile'], 'http'))
                return $this->attributes['profile'];
            return \Storage::url($this->attributes['profile']);
        } 
        
        return null;
    }

    /**
     * Get thumbnail 
     * 
     * @return string
     */
    public function getThumbnailAttribute()
    {
        if ($this->attributes['thumbnail']) {
            if (\Str::startsWith($this->attributes['thumbnail'], 'http'))
                return $this->attributes['thumbnail'];
            return \Storage::url($this->attributes['thumbnail']);
        }

        return null;
    }


    public function availabilities () {
        return $this->hasMany(Availability::class);
    }

    public function rates () {
        return $this->hasMany(Rating::class, 'ratee_id');
    }
}
