<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function createUpdate($notification, $request)
    {
        if (isset($request->title)) {
            $notification->title = $request->title;
        }
        if (isset($request->description)) {
            $notification->description = $request->description;
        }
        if (isset($request->icon)) {
            $notification->icon = $request->icon;
        } 
        if (isset($request->design_type)) {
            $notification->design_type = $request->design_type;
        } 
        $notification->save();
        return $notification;
    }
}
