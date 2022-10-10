<?php

namespace App\Http\Controllers\Views\Frontend;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{

    public function notifications () {
    	try{
	    	$notifications = Auth::user()->notifications;
	    	Auth::user()->unreadNotifications->markAsRead();
	    	//var_dump($notifications[1]); die();
	        return view('frontend.organizations.notifications.notifications', compact('notifications'));
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Get unread notification
     * @return Json json()
     */
    public function unread (){
    	try{
            $unread_notif =Auth::user()->unreadNotifications;
            $count =count($unread_notif);
            return response()->json(compact('count'));
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
