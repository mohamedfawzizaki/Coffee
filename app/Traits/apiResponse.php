<?php

namespace App\Traits;

trait apiResponse
{
    public function success($message)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function error($message, $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    public function notFound($message = 'Data Not Found')
    {
        $response = [
            'success' => false,
            'message' => __($message),
        ];

        return response()->json($response, 404);
    }
}
