<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    /**
     * success response message
     * 
     * @param mixed $result 
     * @param string $message
     *  
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendReponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response);
    }

    /**
     * error response message
     * 
     * @param mixed $error 
     * @param array $message
     * @param int $code
     *  
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $message = [], $code = Response::HTTP_NOT_FOUND): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(! empty($error))
        {
            $response['data'] = $error;
        }

        return response()->json($response, $code);
    }
}
