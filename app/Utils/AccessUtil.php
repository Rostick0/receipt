<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\builder;
use Illuminate\Http\JsonResponse;

class AccessUtil
{
    public static function cannot(string $method, $model): bool
    {
        return !auth()->check() || auth()->user()->cannot($method, $model);
    }

    public static function errorMessage($message = null, $code = 403): JsonResponse
    {
        if (!$message) {
            return new JsonResponse([
                'message' => $message
            ], $code);
        }

        return abort(403);
        // return new JsonResponse([
        //     'message' => __('auth.access')
        // ],  403);
    }
}
