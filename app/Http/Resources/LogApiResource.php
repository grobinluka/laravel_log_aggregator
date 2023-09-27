<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogApiResource extends JsonResource
{
    public static function success($message)
    {
        return new self([
            'success' => $message
        ]);
    }

    public static function error($message)
    {
        return new self([
            'error' => $message
        ]);
    }
}
