<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
use LeaRecordShop\Response;

class Controller extends BaseController
{
    protected function handleResponse(Response $response): JsonResponse
    {
        if (!$response->isSuccess()) {
            return response()->json(['status' => 'failed', 'errors' => $response->errors()], 422);
        }

        return response()->json(['status' => 'success', 'data' => $response->data()]);
    }
}
