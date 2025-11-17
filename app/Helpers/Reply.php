<?php

namespace App\Helpers;

class Reply
{
    public static function success(string $message = '', array $data = [])
    {
        return response()->json(array_merge([
            'success' => true,
            'status' => 'success',
            'message' => $message,
        ], $data));
    }

    public static function error(string $message = '', array $data = [], int $code = 400)
    {
        return response()->json(array_merge([
            'success' => false,
            'status' => 'error',
            'message' => $message,
        ], $data), $code);
    }

    public static function successWithData(string $message = '', array $data = [])
    {
        return self::success($message, ['data' => $data]);
    }
}
