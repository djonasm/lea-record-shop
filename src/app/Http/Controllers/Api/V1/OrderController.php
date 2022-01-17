<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use LeaRecordShop\Order\Repository;
use LeaRecordShop\Order\Service;
use InvalidArgumentException;

class OrderController extends BaseController
{
    /**
     * @var Service $service
     */
    private $service;

    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Service $service, Repository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
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
        try {
            $data = $this->repository->create($request->only('clientId', 'recordId'));
        } catch (InvalidArgumentException $exception) {
            return response()->json(['status' => 'failed', 422]);
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function delete(int $id): JsonResponse
    {
        if (!$this->repository->delete($id)) {
            return response()->json(['status' => 'failed', 422]);
        }

        return response()->json(['status' => 'success']);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        if (!$this->repository->update($id, $request->only('clientId', 'recordId'))) {
            return response()->json(['status' => 'failed', 422]);
        }

        return response()->json(['status' => 'success']);
    }
}
