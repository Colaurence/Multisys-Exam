<?php

namespace App\Traits;

trait ApiResponse
{
    public function ApiResponse($message, $code)
    {
        return response()->json(['message' => $message], $code);
    }

    
}
