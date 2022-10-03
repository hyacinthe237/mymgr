<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    use SoftDeletes, Uuids;

    protected $table = 'dishes';
    protected $guarded = ['id'];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function cuisine () {
        return $this->belongsTo(Cuisine::class);
    }

    /**
     * Get profile photo 
     * 
     * @return string
     */
    public function getPhotoAttribute()
    {
        if ($this->attributes['photo']) {
            return \Storage::url($this->attributes['photo']);
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
            return \Storage::url($this->attributes['thumbnail']);
        }

        return null;
    }
}
