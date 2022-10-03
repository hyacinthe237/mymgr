<?php

namespace App\Utilities;

use Webpatser\Uuid\Uuid;

trait Uuids
{

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Uuid::generate()->string;
        });
    }


    public function generateUuid () {
        return Uuid::generate()->string;
    }
}
