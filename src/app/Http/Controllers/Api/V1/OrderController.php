<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use LeaRecordShop\Order\Repository;
use LeaRecordShop\Order\Service;
use InvalidArgumentException;

/**
 * @group Order management
 *
 * APIs for managing orders
 */
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

    /**
     * Get orders.
     *
     * This endpoint allows you to get orders.
     * It`s possible to use clientId, startDate or endDate filter.
     *
     * @urlParam clientId integer The id of the client.
     * @urlParam startDate The filter for minimum order created date. Example: 2020-08-15T15:52:01+00:00
     * @urlParam endDate The filter for maximum order created date. Example: 2021-08-15T15:52:01+00:00
     */
    public function list(Request $request): JsonResponse
    {
        $data = $this->service->list(
            $request->get('clientId'),
            $request->get('startDate'),
            $request->get('endDate'),
        );

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Create a order.
     *
     * @bodyParam clientId int required The id of the client. Example: 1
     * @bodyParam recordId int required The id of the record. Example: 9
     *
     * @response scenario=success {
     *  "id": 4,
     *  "clientId": 6,
     *  "recordId": 9
     * }
     *
     * @response status=422 scenario="Invalid input {"status": "failed", "message": "Invalid Input"}
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $data = $this->repository->create($request->only('clientId', 'recordId'));
        } catch (InvalidArgumentException $exception) {
            return response()->json(['status' => 'failed', 'message' => 'Invalid input'], 422);
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Delete a order.
     *
     * @urlParam id integer require The id of the order.
     *
     * @bodyParam clientId int The id of the client. Example: 1
     * @bodyParam recordId int The id of the record. Example: 9
     */
    public function delete(int $id): JsonResponse
    {
        if (!$this->repository->delete($id)) {
            return response()->json(['status' => 'failed', 422]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Update a order.
     *
     * @urlParam id integer require The id of the order.
     *
     * @bodyParam clientId int The id of the client. Example: 1
     * @bodyParam recordId int The id of the record. Example: 9
     */
    public function update(int $id, Request $request): JsonResponse
    {
        if (!$this->repository->update($id, $request->only('clientId', 'recordId'))) {
            return response()->json(['status' => 'failed', 422]);
        }

        return response()->json(['status' => 'success']);
    }
}
