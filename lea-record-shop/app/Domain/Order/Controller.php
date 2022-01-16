<?php

namespace LeaRecordShop\Order;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var Service $service
     */
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function list(Request $request): JsonResponse
    {
        $data = $this->service->list(
            $request->get('clientId'),
            $request->get('startDate'),
            $request->get('endDate'),
        );

        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
