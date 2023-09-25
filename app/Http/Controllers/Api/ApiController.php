<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function successResponse($message, $result = [], $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result
        ];

        return response()->json($response, $code);
    }

    public function errorResponse($message, $result = [], $code = 400)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($result)) {
            $response['errors'] = $result;
        }

        return response()->json($response, $code);
    }

    public function unauthorizedResponse()
    {
        $response = [
            'success' => false,
            'message' => 'You are not authorized to access this resource',
        ];

        return response()->json($response, 401);
    }

    public function forbiddenResponse()
    {
        $response = [
            'success' => false,
            'message' => 'You are not authorized to access this resource, permission denied',
        ];

        return response()->json($response, 401);
    }
}
