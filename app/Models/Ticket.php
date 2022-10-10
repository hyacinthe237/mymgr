<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    // use SoftDeletes, LogsActivity;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status', 'priority',
        'complexity', 'project_id', 'created_by', 'parent_id', 'assignee_id',
        'number', 'start_date', 'end_date', 'estimate', 'is_open'
    ];

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
    protected $table = 'tickets';


    protected static $logOnlyDirty  = true;
    protected static $logAttributes = ['*'];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logAttributesToIgnore = ['updated_at'];


    public function __construct(array $attributes = array()) {
       parent::__construct($attributes);
    }


    public function scopeLast ($q) {
        return $q->orderBy('id', 'desc')->first();
    }


    public function project() {
       return $this->belongsTo("App\Models\Project",'project_id');
    }
    public function createdBy() {
        return $this->hasOne('App\Models\User','id','created_by');
    }

    public function assignee() {
        return $this->belongsTo('App\Models\User','assignee_id', 'id');
    }

    public function parent() {
        return $this->hasOne('App\Models\Ticket','id', 'parent_id');
    }

    public function comments(){
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    public function children(){
        return $this->hasMany('App\Models\Ticket', 'parent_id');
    }

    public function category () {
        return $this->belongsTo(TicketCategory::class, 'status', 'id');
    }

    public function files () {
        return $this->morphMany(File::class, 'fileable');
    }

    public function toggleOpen () {
        $this->is_open = (bool) !$this->is_open;
    }


    public function activities () {
        return $this->activity()->with(['causer' => function ($query) {
            $query->select('id', 'firstname', 'lastname', 'code');
        }])->get();
    }



}
