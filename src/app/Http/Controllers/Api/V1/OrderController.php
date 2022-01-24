<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
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
     * It`s possible to use userId, startDate or endDate filter.
     *
     * @urlParam userId integer The id of the user.
     * @urlParam startDate The filter for minimum order created date. Example: 2020-08-15T15:52:01+00:00
     * @urlParam endDate The filter for maximum order created date. Example: 2021-08-15T15:52:01+00:00
     */
    public function list(Request $request): JsonResponse
    {
        $data = $this->service->list(
            $request->get('userId'),
            $request->get('startDate'),
            $request->get('endDate'),
        );

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Create a order.
     *
     * @bodyParam userId int required The id of the user. Example: 1
     * @bodyParam recordId int required The id of the record. Example: 9
     *
     * @response scenario=success {
     *  "id": 4,
     *  "userId": 6,
     *  "recordId": 9
     * }
     *
     * @response status=422 scenario="Invalid input {"status": "failed", "message": "Invalid Input"}
     */
    public function create(Request $request): JsonResponse
    {
        $response = $this->repository->create(
            $request->only('userId', 'recordId')
        );

        return $this->handleResponse($response);
    }

    /**
     * Delete a order.
     *
     * @urlParam id require The id of the order.
     */
    public function delete(string $id): JsonResponse
    {
        if (!$this->repository->delete($id)) {
            return response()->json(['status' => 'failed'], 422);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Update a order.
     *
     * @urlParam id require The id of the order.
     *
     * @bodyParam userId int The id of the user. Example: 1
     * @bodyParam recordId int The id of the record. Example: 9
     */
    public function update(string $id, Request $request): JsonResponse
    {
        $response = $this->repository->update(
            $id,
            $request->only('userId', 'recordId')
        );

        return $this->handleResponse($response);
    }
}
