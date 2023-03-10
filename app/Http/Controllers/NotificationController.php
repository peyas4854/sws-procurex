<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class NotificationController extends Controller
{
    public function index(Request $request){

        // dd($request->all());

        $data = $request->except("_token");

        $notification_types_in_db = Notification::pluck('type')->toArray();

        $unique_notification_types = array_unique($notification_types_in_db);

        $notification_class_names = [];

        foreach($unique_notification_types as $type){
            array_push( $notification_class_names , Str::headline(class_basename($type)));
        }

        $notification_type = $notification_class_names;

        $query = Notification::query();

        $query->where("notifiable_id",auth()->user()->id);
        
        $query->orderby("created_at","DESC");

        if($request->type){

            // $type = $request->type;
            
            // $filtered_array = array_filter($notification_class_names, function ($value) use ($type) {
            //     return in_array($type,[$value]);
            // });

            $type = 'App\Notifications\\'.Str::studly($request->type);

            $query->whereType($type);
            // dd($query->whereType($type)->get());
        }

        if($request->date_filter){

            $parts = explode(' - ' , $request->date_filter);
    
            $date_from = Carbon::parse($parts[0]);

            $date_to = Carbon::parse($parts[1]);

            $query->whereBetween('created_at', [$date_from->startOfDay(), $date_to->endOfDay()]);

        }
        
        $myNotifications = $query->paginate(10)->appends($data);
        $myNotifications->pagination_summary = get_pagination_summary($myNotifications);

        // dd($myNotifications);
        
        return view('notifications.list',compact("myNotifications","notification_type"));
    
    }

    public function markAsRead()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
