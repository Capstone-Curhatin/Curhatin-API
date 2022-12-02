<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function sendNotification(Request $request){
        $url = "https://fcm.googleapis.com/fcm/send";
        $token = User::find($request->to, ['fcm']);
        $serverKey = "AAAAZanJlNE:APA91bGmaMofkDVm9hhV_Y8Gekaw6Udd3zDpWYf1G8XAPsNWFW4n3ibW8-QOoUQa64J25-ljq6EKx3tV67EOeX7MGkvczR-RAwMl72vr2z5QhxydjAGFiuWCjAWQ1xaz8ytXXMyz_zAM";


        $data = [
            "to" => $token->fcm,
            "data" => [
                "title" => $request->title,
                "body" => $request->body
            ]
        ];

        $encodeData = json_encode($data);
        $headers = [
            'Authorization: key='.$serverKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodeData);
        // Execute post
        $result = curl_exec($ch);
        if (!$result){
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        // Fcm Response
        dd($result);
    }

}
