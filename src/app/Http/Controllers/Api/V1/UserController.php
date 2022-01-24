<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LeaRecordShop\User\Repository;

/**
 * @group User management
 *
 * APIs for managing users
 */
class UserController extends BaseController
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get users.
     *
     * This endpoint allows you to get users.
     * It`s possible to use userId, startDate or endDate filter.
     *
     * @urlParam genre The genre of the user.
     * @urlParam releaseYear integer The release year of the user.
     * @urlParam artist The artist of the user.
     * @urlParam name The name of the user.
     */
    public function list(Request $request): JsonResponse
    {
        $data = $this->repository->list();

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Create a user.
     *
     * @bodyParam name required The genre of the user. Example: vocal
     * @bodyParam email required The release year of the user. Example: 2019
     * @bodyParam fiscalId The fiscal id of the user. Example: 111.111.111-11
     * @bodyParam birthdate The birthdate of the user. Example: 2020-05-01
     * @bodyParam gender The gender of the user. Example: other
     * @bodyParam address The street of the user. Example: Rua Joao Dias
     * @bodyParam addressNumber The address number of the user. Example: 123
     * @bodyParam addressState number required The from price of the user. Example: 120.01
     * @bodyParam neighborhood number required The to price of the user. Example: 99.99
     * @bodyParam city int required The stock quantity of the user. Example: 200
     * @bodyParam zipcode int required The stock quantity of the user. Example: 200
     *
     * @response scenario=success {
     *  "id": 4,
     *  "name": John Days,
     *  "email": johndays@johndays.com,
     *  "fiscalId": 111.111.111-11,
     *  "birthDate": 2020-05-01,
     *  "gender": other,
     *  "address": Rua Joao Dias,
     *  "addressNumber": 2200,
     *  "addressState": SP,
     *  "neighborhood": Santo Amaro,
     *  "city": São Paulo,
     *  "zipcode": 04720-160,
     * }
     *
     * @response status=422 scenario="Invalid input {"status": "failed", "message": "Invalid Input"}
     */
    public function create(Request $request): JsonResponse
    {
        $response = $this->repository->create(
            $request->only(
                'name',
                'email',
                'fiscalId',
                'birthDate',
                'gender',
                'phone',
                'address',
                'addressNumber',
                'addressState',
                'neighborhood',
                'city',
                'zipcode',
            )
        );

        return $this->handleResponse($response);
    }

    /**
     * Delete a user.
     *
     * @urlParam id integer require The id of the user.
     */
    public function delete(int $id): JsonResponse
    {
        if (!$this->repository->delete($id)) {
            return response()->json(['status' => 'failed'], 422);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Update a user.
     *
     * @urlParam id integer require The id of the user.
     *
     * @bodyParam genre The genre of the user. Example: vocal
     * @bodyParam releaseYear int The release year of the user. Example: 2019
     * @bodyParam artist The artist of the user. Example: Adele
     * @bodyParam name The name of the user. Example: Adele Live at the Royal Albert Hall
     * @bodyParam label The label of the user. Example: Columbia Sony
     * @bodyParam trackList string[] The track list of the user. Example: ["1 - Hometown Glory", "2 - "I'll Be Waiting"]
     * @bodyParam description The description of the user. Example: Adele Live at the Royal Albert Hall
     * @bodyParam fromPrice number The from price of the user. Example: 120.01
     * @bodyParam toPrice number The to price of the user. Example: 99.99
     * @bodyParam stockQuantity int The stock quantity of the user. Example: 200
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
