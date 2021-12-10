<?php

namespace App\Helpers;

class ResponseBuilder {
    public static function buildResponse($message, $data) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function buildErrorResponse($message, $errors, $error_code) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $error_code);
    }
}
