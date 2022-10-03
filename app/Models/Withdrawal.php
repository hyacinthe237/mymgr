<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes, Uuids;

    protected $table = 'withdrawals';
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_cleared'   => 'datetime'
    ];


    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clearedBy () {
        return $this->belongsTo(User::class, 'cleared_by');
    }
}
