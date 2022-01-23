<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LeaRecordShop\Record\Repository;
use LeaRecordShop\Record\Service;

/**
 * @group Record management
 *
 * APIs for managing records
 */
class RecordController extends BaseController
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
     * Get records.
     *
     * This endpoint allows you to get records.
     * It`s possible to use userId, startDate or endDate filter.
     *
     * @urlParam genre The genre of the record.
     * @urlParam releaseYear integer The release year of the record.
     * @urlParam artist The artist of the record.
     * @urlParam name The name of the record.
     */
    public function list(Request $request): JsonResponse
    {
        $data = $this->service->list(
            $request->get('genre'),
            $request->get('releaseYear'),
            $request->get('artist'),
            $request->get('name'),
        );

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Create a record.
     *
     * @bodyParam genre required The genre of the record. Example: vocal
     * @bodyParam releaseYear int required The release year of the record. Example: 2019
     * @bodyParam artist required The artist of the record. Example: Adele
     * @bodyParam name required The name of the record. Example: Adele Live at the Royal Albert Hall
     * @bodyParam label The label of the record. Example: Columbia Sony
     * @bodyParam trackList string[] The track list of the record. Example: ["1 - Hometown Glory", "2 - "I'll Be Waiting"]
     * @bodyParam description The description of the record. Example: Adele Live at the Royal Albert Hall
     * @bodyParam fromPrice number required The from price of the record. Example: 120.01
     * @bodyParam toPrice number required The to price of the record. Example: 99.99
     * @bodyParam stockQuantity int required The stock quantity of the record. Example: 200
     *
     * @response scenario=success {
     *  "id": 4,
     *  "genre": rock,
     *  "releaseYear": 2000,
     *  "artist": Disturbed,
     *  "name": The Sickness,
     *  "label":  Giant Records,
     *  "trackList": [Voices, The Game, Stupify],
     *  "description": Nice,
     *  "fromPrice": 30.00,
     *  "toPrice": 19.90,
     *  "stockQuantity": 2,
     * }
     *
     * @response status=422 scenario="Invalid input {"status": "failed", "message": "Invalid Input"}
     */
    public function create(Request $request): JsonResponse
    {
        $response = $this->repository->create(
            $request->only(
                'genre',
                'releaseYear',
                'artist',
                'name',
                'label',
                'trackList',
                'description',
                'fromPrice',
                'toPrice',
                'stockQuantity',
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * Delete a record.
     *
     * @urlParam id integer require The id of the record.
     */
    public function delete(int $id): JsonResponse
    {
        if (!$this->repository->delete($id)) {
            return response()->json(['status' => 'failed'], 422);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Update a record.
     *
     * @urlParam id integer require The id of the record.
     *
     * @bodyParam genre required The genre of the record. Example: vocal
     * @bodyParam releaseYear int required The release year of the record. Example: 2019
     * @bodyParam artist required The artist of the record. Example: Adele
     * @bodyParam name required The name of the record. Example: Adele Live at the Royal Albert Hall
     * @bodyParam label The label of the record. Example: Columbia Sony
     * @bodyParam trackList string[] The track list of the record. Example: ["1 - Hometown Glory", "2 - "I'll Be Waiting"]
     * @bodyParam description The description of the record. Example: Adele Live at the Royal Albert Hall
     * @bodyParam fromPrice number required The from price of the record. Example: 120.01
     * @bodyParam toPrice number required The to price of the record. Example: 99.99
     * @bodyParam stockQuantity int required The stock quantity of the record. Example: 200
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $response = $this->repository->update(
            $id, $request->only(
                'genre',
                'releaseYear',
                'artist',
                'name',
                'label',
                'trackList',
                'description',
                'fromPrice',
                'toPrice',
                'stockQuantity',
            )
        );

        return $this->handleResponse($response);
    }
}
