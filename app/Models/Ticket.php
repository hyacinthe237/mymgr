<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes, Uuids;

    protected $table = 'tickets';
    protected $guarded = ['id'];


    public function client () {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignee () {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function updater () {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
