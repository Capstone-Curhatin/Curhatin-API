<?php

namespace App\Helpers;

class ResponseFormatter {

    protected static $response = [
        'success' => null,
        'message' => null,
        'data' => null
    ];

    public static function paginate($data) {
        return response()->json($data, 200);
    }

    public static function success($data = null, $message = null, $success = true) {
        self::$response['success'] = $success;
        self::$response['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, 200);
    }

    public static function error($message = null, $success = false) {
        self::$response['success'] = $success;
        self::$response['message'] = $message;

        return response()->json(self::$response, 401);
    }

}
