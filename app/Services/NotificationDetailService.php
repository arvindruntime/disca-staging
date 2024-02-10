<?php

namespace App\Services;

use App\Models\NotificationDetail;

class NotificationDetailService
{
    public static function createUpdate($notificationDetail, $request)
    {
        if (isset($request->notification_id)) {
            $notificationDetail->notification_id = $request->notification_id;
        }
        if (isset($request->title)) {
            $notificationDetail->title = $request->title;
        } 
        if (isset($request->detail_description)) {
            $notificationDetail->detail_description = $request->detail_description;
        } 
        if (isset($request->icon)) {
            $notificationDetail->icon = $request->icon;
        } 
        
        if (isset($request->status)) {
            $notificationDetail->status = (int)$request->status;
        }

        if (isset($request->is_hide)) {
            $notificationDetail->is_hide = (int)$request->is_hide;
        }
        
        $notificationDetail->save();
        return $notificationDetail;
    }
}
