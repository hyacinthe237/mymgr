<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuisine extends Model
{
    use SoftDeletes, Uuids;

    protected $guarded = ['id'];
    protected $table = 'cuisines';

    public function users () {
        return $this->belongsToMany(User::class);
    }
}
