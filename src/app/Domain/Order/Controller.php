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

    public function create(Request $request): JsonResponse
    {
        $order = new Model();
        $order->fill($request->only('clientId', 'recordId'));
        $order->save();

        return response()->json(['status' => 'success', 'data' => $order->attributesToArray()]);
    }

    public function delete(Request $request): JsonResponse
    {
        $data = [];

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function update(Request $request): JsonResponse
    {
        $data = [];

        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
