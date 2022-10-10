<?php

namespace App\Repositories;

use DB;
use App\Models\User;
use App\Models\Invitation;
use App\Models\Organization;
use App\Repositories\Traits\BaseRepository;
use App\Repositories\Contracts\RepositoryCriteriaInterface;

class InvitationRepository implements RepositoryCriteriaInterface
{
    use BaseRepository;

    /**
     * @var Invitation
     */
    protected $model;

    /**
     * The user that recieved the invitation
     *
     * @var User
     */
    protected $user;

    /**
     * The organization that sent the invitation
     *
     * @var Organization
     */
    protected $organization;

    /**
     * The base url.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * InvitationRepository constructor.
     *
     * @param Invitation $invitation
     * @param User $user
     * @param Organization $organization
     */
    public function __construct(Invitation $invitation,User $user,Organization $organization)
    {
        $this->model = $invitation;
        $this->user = $user;
        $this->organization = $organization;
        $this->baseUrl = 'invitations';
    }

    /**
     * Store a newly created invitation in database.
     *
     * @param Array $input
     * @return Invitation
     */
    /*public function store(array $input): Invitation
    {  
        $userInput=array_filter($input, function($k) {
                return in_array($k, ['firstname', 'lastname', 'email', 'password', 'phone', 'photo', 'gender']);
        }, ARRAY_FILTER_USE_KEY);

        $invitationInput=array_filter($input, function($k) {
                return in_array($k, ['sent_by', 'organization_id']);
        }, ARRAY_FILTER_USE_KEY);

        $position=array_key_exists("position", $input) ? $input["position"] : null;
        $organizationId=array_key_exists("organization_id", $input) ? $input["organization_id"] : null;

        //$this->user->fill($userInput);

        $this->model->fill($input);

        DB::transaction(function() use ($position,$organizationId) {
            // creat a user
            //$this->user
            //->save();
            // creat an invitation
            $this->model
            //    ->user()
            //    ->associate($this->user)
                ->save();
            // associate the organization to the user who recieved an invitation
            $this->organization
                ->find($organizationId)
                ->users()
                ->attach($this->user->id, ['position' => $position]);
            
        });

        return $this->model;
    }*/

}
