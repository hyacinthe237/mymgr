<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use Mail;
use Validator;
use Illuminate\Http\Request;
use App\Mail\OrganizationInvited;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationRequest;
use App\Repositories\InvitationRepository;
use App\Repositories\OrganizationRepository;
use App\Http\Resources\Invitation as InvitationResource;
use App\Http\Resources\InvitationCollection as InvitationCollectionResource;

class InvitationController extends Controller
{

    /**
     * @var InvitationRepository $invitationRepository
     */
    protected $invitationRepository;

    /**
     * InvitationController constructor.
     *
     * @param InvitationRepository $invitationRepository
     */
    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations = $this->invitationRepository->all();
        return  new InvitationCollectionResource($invitations);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationRepository $orgRepo, InvitationRequest $request)
    {
        $user = $request->user();
        $organization = request()->organization;

        $input = $request->all();
        $input['sent_by'] = $user->id;
        $input['organization_id'] = $organization->id;

        try
        {
            // Should not invite members who already joined the organization
            $userIsAlreadyInOrganization = $organization->users()
            ->where('email', $request->email)->first();

            if ($userIsAlreadyInOrganization) {
                return response()->json([
                    'message' => 'The invited user is already a member of this organization'
                ], self::HTTP_BADREQUEST);
            }

            // Do not create multiple invitations for the same email in an organization
            $userPreviousInvitation = $organization->invitations()
            ->where('email', $request->email)->first();

            if ($userPreviousInvitation) {
                $userPreviousInvitation->update(); // changed `updated_at`
                $this->sendInvitation($userPreviousInvitation);
                return response()->json($userPreviousInvitation);
            }

            // Invite a user for the first time
            $invitation = $this->invitationRepository->store($input);
            if (!$invitation)
            return response()->json(['message'=>'Invitation could not be sent'], self::HTTP_BADREQUEST);

            $this->sendInvitation($invitation);
            return response()->json($invitation);
        }
        catch (\Exception $e) {
            return response()->json($e, self::HTTP_ERROR);
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invitation = $this->invitationRepository->getById($id);

        if(is_null($invitation) ) {
            return abort(404);
        }
        return  new InvitationResource($invitation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvitationRequest $request, $id)
    {
        $input = $request->all();
        try {
            $invitation = $this->invitationRepository->getById($id);
            $updated = $this->invitationRepository->update($invitation->id,$input);
            if($updated && isset($updated->id)){
                return response()->json(['id'=>$updated->id],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = $this->invitationRepository->delete($id);
            if($delete){
                return response()->json(['message'=>'the invitation has been deleted'],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }


    /**
     * Send invitation to email
     * @param  [type] $invitation [description]
     * @return [type]             [description]
     */
    private function sendInvitation ($invitation)
    {
        Mail::to($invitation->email)->queue(new OrganizationInvited($invitation));
    }

}
