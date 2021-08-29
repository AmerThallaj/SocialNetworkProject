<?php

namespace App\Http\Controllers;

use App\Models\Users\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications(){
        $user = User::find(auth()->user()->id);
        $notifications =  $user->notifications;
        foreach($notifications as $notification){
            $sender = User::find($notification->user_id);
            $notification->profilePic = $sender->photo()->where('photo_type','=','profile')
                ->where('current','=','1')
                ->first()
                ->url;
            $notification->makeHidden(['user_id','updated_at','created_at']);
        }
        return $notifications;
    }

}
