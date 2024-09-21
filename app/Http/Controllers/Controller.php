<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // Helper Send Response JSON
    public function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, 200);
    }

    // Helper Send Error
    public function sendError($message, $error = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $message,
        ];

        if (!empty($error)) {
            $response['data'] = $error;
        }

        return response()->json($response, $code);
    }
}
