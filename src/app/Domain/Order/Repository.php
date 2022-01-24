<?php

namespace LeaRecordShop\Order;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use LeaRecordShop\BaseModel;
use LeaRecordShop\BaseRepository;
use LeaRecordShop\Response;
use LeaRecordShop\Stock\Service as StockService;

class Repository extends BaseRepository
{
    /**
     * @var Identifier
     */
    private $identifier;

    /**
     * @var Service
     */
    private $service;

    /**
     * @var StockService
     */
    private $stockService;

    public function __construct(
        Service $service,
        StockService $stockService,
        Identifier $identifier
    ) {
        $this->identifier = $identifier;
        $this->service = $service;
        $this->stockService = $stockService;
    }

    public function list(
        ?string $userId = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): array {
        $query = Model::query();
        if ($userId) {
            $query->where(compact('userId'));
        }

        if ($startDate) {
            $query->where('createdAt', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('createdAt', '<=', $endDate);
        }

        return $query->get()->toArray();
    }

    public function create(array $data): Response
    {
        $orderId = $this->identifier->generate();
        $data['id'] = $orderId;

        $response = $this->service->isRecordAvailable($data['recordId'], $orderId);
        if (!$response->isSuccess()) {
            return $response;
        }

        return DB::transaction(
            function () use ($data) {
                $response = parent::create($data);
                if (!$response->isSuccess()) {
                    return $response;
                }

                $stockResponse = $this->stockService->decrementQuantity($data['recordId']);
                if (!$stockResponse->isSuccess()) {
                    return $stockResponse;
                }

                return $response;
            }
        );
    }

    public function delete($id): bool
    {
        $entity = $this->query()
            ->find($id);

        return DB::transaction(
            function () use ($id, $entity) {
                if (!parent::delete($id)) {
                    return false;
                }

                // Release order record stock
                $stockResponse = $this->stockService->incrementQuantity($entity->recordId);
                if (!$stockResponse->isSuccess()) {
                    return false;
                }

                return true;
            }
        );
    }

    public function update($id, array $data): Response
    {
        $entity = $this->query()
            ->find($id);

        // Stock will keep the same
        if (!isset($data['recordId']) || $entity->recordId === $data['recordId']) {
            return parent::update($id, $data);
        }

        return DB::transaction(
            function () use ($id, $data, $entity) {
                $response = parent::update($id, $data);
                if (!$response->isSuccess()) {
                    return $response;
                }

                // Decrease new record stock
                $stockResponse = $this->stockService->decrementQuantity($data['recordId']);
                if (!$stockResponse->isSuccess()) {
                    return $stockResponse;
                }

                // Increase old record stock
                $stockResponse = $this->stockService->incrementQuantity($entity->recordId);
                if (!$stockResponse->isSuccess()) {
                    return $stockResponse;
                }

                return $response;
            }
        );
    }

    protected function entity(): BaseModel
    {
        return app(Model::class);
    }

    protected function query(): Builder
    {
        return Model::query();
    }
}
