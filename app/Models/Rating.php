<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    protected $table = 'ratings';
    protected $guarded = ['id'];


    public function rater () {
        return $this->belongsTo(User::class, 'rater_id');
    }

    public function ratee () {
        return $this->belongsTo(User::class, 'ratee_id');
    }

    public function booking () {
        return $this->belongsTo(Booking::class);
    }
}
