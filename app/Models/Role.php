<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    
    public function documents () 
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
