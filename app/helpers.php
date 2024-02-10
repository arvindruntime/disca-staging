<?php

use App\Models\ChatMsg;
use App\Models\Notification;

if (!function_exists('sendResponse')) {
    function sendResponse($result, $message = "")
    {
        $data = [
            'status' => 200,
            'statusState' => 'success',
            'data'    => $result,
            'message' => (empty($message) ? 'success' : $message),
        ];

        if (request()->wantsJson()) {
            return response()->json($data, 200);
        }

        return $data;
    }
}
if (!function_exists('encryptString')) {
    function encryptString($string)
    {
        $cipher_key = '~OC+b$&!?HJ$%@@E^%@$$Ujs+d$$OC@!';
        $method = 'aes-256-cbc';

        $iv = '~OC+b$&!?HJ$%@@E';

        $encrypted = base64_encode(openssl_encrypt($string, $method, $cipher_key, OPENSSL_RAW_DATA, $iv));

        return $encrypted;
    }
}

if (!function_exists('decryptString')) {
    function decryptString($string)
    {
    //     $cipher_key = '~OC+b$&!?HJ$%@@E^%@$$Ujs+d$$OC@!';
    //     $method = 'aes-256-cbc';

    //     $iv = '~OC+b$&!?HJ$%@@E';

    //     $decrypted = openssl_decrypt(base64_decode($string), $method, $cipher_key, OPENSSL_RAW_DATA, $iv);

        // return $decrypted;
        return $string;
    }
}

if (!function_exists('sendError')) {
    function sendError($code = 500, $error = "", $exceptionMsg = '')
    {
        if (!empty($exceptionMsg)) {
            \Log::error($exceptionMsg);
        }

        if (request()->wantsJson()) {
            return response()->json(
                [
                    'status' => 400,
                    'statusState' => 'error',
                    'message' => (empty($error) ? 'Something went wrong' : $error),
                ],
                400
            );
        }

        $response = [
            'status' => 400,
            'statusState' => 'error',
            'message' => (empty($error) ? 'Something went wrong' : $error),
        ];

        return $response;
    }
}
if (!function_exists('notificationList')) {
    function notificationList()
    {
        $user = auth()->user();
        if (!empty($user)) {

            $notificationSettingArray = explode(",", $user->notification_setting);
            $notifications = Notification::with(['notification_detail' => function ($query) {
                $query->where('is_hide', 0);
            }])->get();

            for ($i = 0; $i < count($notifications); $i++) {
                foreach ($notifications[$i]['notification_detail'] as $key => $notification) {
                    if (in_array($notification['id'], $notificationSettingArray)) {
                        $notifications[$i]['notification_detail'][$key]['status'] = 1;
                    } else {
                        $notifications[$i]['notification_detail'][$key]['status'] = 0;
                    }
                }
            }
            return $notifications;
        } else {
            return false;
        }
    }
}

if (!function_exists('CheckValue')) {
    function CheckValue($param = "", $defolt_valaue = "")
    {
        if (!empty($param)) {
            return !empty($param) ? $param : $defolt_valaue;
        }
    }
}

if (!function_exists('UploadImage')) {
    function UploadImage($file_name = "", $upload_path = "", $image = "", $size = "")
    {
        if (empty($file_name) || empty($upload_path) || empty($image)) {
            return false;
        }

        !is_dir($upload_path) &&
                mkdir($upload_path, 0777, true);
                
        $image->move($upload_path, $file_name);
        return true;
    }
}

if (!function_exists('DeleteImage')) {
    function DeleteImage($file_path = "")
    {
        if (empty($file_path)) {
            return false;
        }
        if (file_exists($file_path)) {
            unlink($file_path);
            return true;
        }
    }
}

//////// Functions for chat module
if (!function_exists('unreadMessagesCount')) {
    function unreadMessagesCount($from, $to) {
        return ChatMsg::where('from', $from)->where('user_id', $to)->where('status', '0')->get()->count();
    }
}

if (!function_exists('allMessageCount')) {
    function allMessageCount($from) {
        return ChatMsg::where('from', $from)->get()->count();
    }
}

if (!function_exists('get_user_timezone')) {
    function get_user_timezone()
    {
        try {

            if (\Session::has('user_timezone')) {
                return \Session::get('user_timezone');
            } else {
                // Get user timezone
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'],
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                ));

                // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, env('CURLOPT_SSL_VERIFYHOST', TRUE));
                // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, env('CURLOPT_SSL_VERIFYPEER', TRUE));

                if (curl_error($curl)) {
                    \Log::error(curl_error($curl));
                    curl_close($curl);
                    return config('app.timezone');
                }

                $response = curl_exec($curl);

                if (!$response) {
                    return config('app.timezone');
                }

                curl_close($curl);

                $data = unserialize($response);
                if ($data['geoplugin_timezone']) {
                    $timezone = $data['geoplugin_timezone'];
                    \Session::put('user_timezone', $timezone);

                    return $timezone;
                } else {
                    return config('app.timezone');
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return config('app.timezone');
        }
    }
}


if (!function_exists('setEmptyData')) {
    /**
    * Apply a empty string instead of null recursively to every member of an array
    * Set "" value instead of NULL in data
    * passing eloquent object inside array_walk_recursive
    * before passing we need to convert into array from eloquent object using ->toArray() method
    * @param array $arr
    * @return array
    */
    function setEmptyData($arr)
    {
        $key = '';
        if (is_array($arr)) {
            array_walk_recursive($arr, function (&$item, $key) {
                $item = null === $item ? '' : $item;
            });
        }
        return $arr;
    }
}