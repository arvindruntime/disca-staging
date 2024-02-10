<?php

namespace App\Http\Controllers\api\v1;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\NotificationDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationDetailService;
use App\Http\Resources\NotificationDetailResource;


class NotificationDetailController extends Controller
{
    //
    public $service;
    function __construct(NotificationDetailService $notificationDetailService)
	{
		$this->service = $notificationDetailService;
	}

    /**
     * Notification Detail List API
     * @group Notification Details
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $notificationSettingArray = explode(",",$user->notification_setting);
        $notificationDetails = NotificationDetail::all();
        $notificationDetails = NotificationDetailResource::collection($notificationDetails);
        foreach($notificationDetails as $key => $notificationDetail)
        {
            if(in_array($notificationDetail['id'],$notificationSettingArray))
            {
                $notificationDetails[$key]['status'] = 1;
            }
            else{
                $notificationDetails[$key]['status'] = 0;
            }
        }
        return sendResponse($notificationDetails, 'Notification details listed successfully.');
    }

    /**
     * Add Notification Detail API
     * @group Notification Details
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required',
            'title' => 'required',
        ],
        [
            'notification_id.required' => 'Please enter the notification id',
            'title.required' => 'Please enter the notification detail title',
        ]);
   
        if($validator->fails()){
            return response()->json(
                [
                    'status' => 422,
                    'statusState' => 'error',
                    'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                ],422
            );       
        }
        $notificationDetail = NotificationDetailService::createUpdate(new NotificationDetail, $request);
        $notificationDetail = new NotificationDetailResource($notificationDetail);
        return sendResponse($notificationDetail, 'Notification detail added successfully.');
    }

    /**
     * Get Notification Detail API
     * @group Notification Details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notificationDetail = NotificationDetail::find($id);
        if(!empty($notificationDetail)) {
            $notificationDetail = new NotificationDetailResource($notificationDetail);
            return sendResponse($notificationDetail, 'Notification detail fetched successfully.');
        }  
        else
        {
            return sendError('Error Occurred');
        }
    }

    /**
     * Edit Notification Detail API
     * @group Notification Details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required',
            'title' => 'required',
        ],
        [
            'notification_id.required' => 'Please enter the notification id',
            'title.required' => 'Please enter the notification detail title',
        ]);
        if($validator->fails()){
            return response()->json(
                [
                    'status' => 422,
                    'statusState' => 'error',
                    'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                ],422
            );       
        }

        $notificationDetail = NotificationDetail::find($id);
        if(!empty($notificationDetail)) 
        {
            $notificationDetail = NotificationDetailService::createUpdate($notificationDetail, $request);
            $notificationDetail = new NotificationDetailResource($notificationDetail);
            return sendResponse($notificationDetail, 'Notification updated successfully.');
        }
        else
        {
            return sendError('Error Occurred');
        }
    }

    /**
     * Delete Notification Detail API
     * @group Notification Details
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notificationDetail = NotificationDetail::find($id);
        if(!empty($notificationDetail))
        {
            $notificationDetail->delete();
            $notificationDetail = new NotificationDetailResource($notificationDetail);
            return sendResponse($notificationDetail, 'Notification detail deleted successfully.');
        }
        else
        {
            return sendError('Error Occurred');
        }
    }

    /**
     * Change status Notification Detail API
     * @group Notification Details
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $status_on = explode(",", $request->status_on);
        $status_off = explode(",", $request->status_off);
        $user_id = Auth::user()->id;
        
        $notificationDetail = "";

            foreach($status_on as $notification_id)
            {
                $notificationDetail = NotificationDetail::where('id', $notification_id)->update(['status' => 1]);
            }
            $notificationDetail = User::where('id', $user_id)->update(['notification_setting' => $request->status_on]);

           

        return sendResponse($notificationDetail, 'Notifications updated successfully.');
    }
   /**
     * Edit Notification setting API
     * @group Notification Details
     * @return \Illuminate\Http\Response
     */
    public function notificationSetting()
    {
        $user = auth()->user();
        $notificationSetting['notificationSetting'] = $user->notification_setting;
        return sendResponse($notificationSetting, 'Notification setting fetched.');
    }   
}
