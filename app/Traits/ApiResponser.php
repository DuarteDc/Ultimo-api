<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait ApiResponser
{
    protected function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }
    protected function errorResponse($message, $code)
    {
        return response()->json(['message' => $message, 'code' => $code], $code);
    }
    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse(['data' => $collection], $code);
    }
    protected function showOne($instance, $code = 200)
    {
        return $this->successResponse(['data' => $instance], $code);
    }

    protected function showMessage($message, $code = 204)
    {
        return $this->successResponse(['message' => $message], $code);
    }
}
