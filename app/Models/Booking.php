<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes, Uuids;

    protected $table = 'bookings';
    protected $guarded = ['id'];

    public function client () {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function chef () {
        return $this->belongsTo(User::class, 'chef_id');
    }

    public function dishes () {
        return $this->belongsToMany(Dish::class, 'booking_dishes', 'booking_id', 'dish_id')
            ->withPivot('serves', 'duration', 'price');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function rates () {
        return $this->hasMany(Rating::class);
    }
}
