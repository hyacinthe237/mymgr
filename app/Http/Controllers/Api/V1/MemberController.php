<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * Get organization ongoing invitations
     * @param  Request $request
     * @return Json json()
     */
    public function index (Request $request)
    {
        try
        {
            $user = Auth::user();
            $organization = $request->organization;
            $members = $organization->users()->orderBy('firstname')->get();
            $invitations = $organization->invitations()->whereStatus('pending')->get();

            $index = 0;

            foreach ($members as $item) {
                if ($user->id == $item->id) {
                    unset($members[$index]);
                }
                $index++;
            }

            return response()->json(compact('members', 'invitations', 'userConnect', 'organization'));
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Remove member resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $organization = $request->organization;
            $member = $organization->users()->where('id', $id)->first();

            if (!$member)
                return response()->json("Member not found", 404);

            $member->delete($id);
            return response()->json("Member deleted successfully");

        }catch (\Exception $e) {
            return response()->json(['message' => 'internal server error'], self::HTTP_ERROR);
        }
    }
}
