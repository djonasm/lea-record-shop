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
     * @var StockService
     */
    private $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    protected function entity(): BaseModel
    {
        return app(Model::class);
    }

    protected function query(): Builder
    {
        return Model::query();
    }

    public function create(array $data): Response
    {
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

    public function delete(int $id): bool
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
}
