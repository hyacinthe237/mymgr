<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $table = 'availabilities';
    protected $guarded = ['id'];

    public function user () {
        return $this->belongsTo(User::class);
    }
}
