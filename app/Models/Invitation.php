<?php

namespace App\Models;

use Auth;
use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use SoftDeletes, Uuids;

    const STATUS_PENDING  = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_DENIED   = 'denied';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invitations';

	/**
	* primary key
	*/
	protected $primaryKey = "id";


    public function sentBy() {
       return $this->belongsTo("App\Models\User",'sent_by');
    }

    public function organization() {
       return $this->belongsTo("App\Models\Organization",'organization_id');
    }



    public function __construct(array $attributes = array()) {
       parent::__construct($attributes);
    }


    public function scopePending ($query) {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeAccepted ($query) {
        return $query->where('status', self::STATUS_ACCEPTED);
    }


}
