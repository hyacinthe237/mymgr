<?php

namespace App\Models;

use App\Utilities\Uuids;
use App\Notifications\TicketOpened;
use App\Notifications\TicketAssigned;
use Illuminate\Notifications\Notifiable;
use App\Notifications\TicketStatusUpdated;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, Uuids;
    // use Notifiable, SoftDeletes, Uuids, CausesActivity;

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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
    * primary key
    */
    protected $primaryKey = "id";

    /**
     * Appended attributes
     * @var [type]
     */
    protected $appends = ['name'];

    public $slack_webhook_url;


    public function __construct(array $attributes = array()) {
         parent::__construct($attributes);
    }


    public function projects(){
        return $this->hasMany(Project::class, 'owner_id');
    }

    public function hasProjects () {
        return $this->belongsToMany(Project::class, 'project_users');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'created_by');
    }

    public function organizations() {
        return $this->belongsToMany(Organization::class,'user_organizations')
                ->withPivot('position')
                ->withTimestamps();
    }


    public function createdorganisations () {
        return $this->hasMany(Organization::class, 'admin_id');
    }


    public function hasOrganisations () {
        return $this->organizations()->count();
    }


    public function logins() {
        return $this->hasMany(Login::class);
    }

    public function invitations() {
        return $this->hasMany(Invitation::class, 'sent_by');
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    public function getNameAttribute () {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function tickets(){
        return $this->hasMany(Ticket::class, 'assignee_id');
    }


    public function save(array $options = []) {
        // before save code
        if (!array_key_exists('api_token', $this->attributes)){
            $this->attributes['api_token'] = bcrypt('token');
        }

        parent::save($options);
    }
    /**
     * Send the ticket updated status notification.
     *
     * @param  User  $from the user who updated the status
     * @param  Ticket  $ticket the ticket that has been mutated
     * @return void
     */
    public function sendTicketStatusNotification($from,$ticket)
    {

        if ($this->id!=$from->id) {
            $this->notify(new TicketStatusUpdated($from,$ticket));
        }

    }

    /**
     * Send the ticket notification when ticket is assigned to a user
     *
     * @param  User  $from the user who assigned the ticket
     * @param  Ticket  $ticket the ticket that has been mutated
     * @return void
     */
    public function sendTicketAssignedNotification($from,$ticket)
    {

        if ($this->id!=$from->id) {
            $this->notify(new TicketAssigned($from,$ticket));
        }
    }

    /**
     * Send the ticket notification when ticket has been opened or closed
     *
     * @param  User  $from the user who perform the action
     * @param  Ticket  $ticket the ticket that has been mutated
     * @return void
     */
    public function sendTicketOpenedNotification($from,$ticket,$action)
    {
        if ($this->id!=$from->id) {
            $this->notify(new TicketOpened($from,$ticket,$action));
        }
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.'.$this->id;
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return $notification->ticket->project->slack_channel;
    }
}
