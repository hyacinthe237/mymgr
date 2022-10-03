<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes, Uuids;

    protected $table = 'documents';
    protected $guarded = ['id'];

    public function commentable()
    {
        return $this->morphTo();
    }
}
