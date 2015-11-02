<?php  namespace App\Http\Controllers;
use App\Model\Notification;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: user
 * Date: 08/05/2015
 * Time: 15:05
 */
class NotificationController extends Controller
{

    public function show(){

        $notifications= Auth::User()->notifications;
        return view('notification')->with(compact('notifications'));

    }

    public function notificationVu($id){
        $notif = Notification::findOrFail($id);
        if( Auth::User()->id == $notif->user_id){
            $notif->vu = 1;
            $notif->save();
            return redirect($notif->url);
        }
        else{
            abort(404);
        }
    }

}