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
        $entity = $this->entity()->fill($data);

        if (!$entity->validate()) {
            return new Response(false, $entity->errors());
        }

        return DB::transaction(function() use ($entity, $data) {
            if (!$entity->save()) {
                return new Response(false);
            }

            $response = $this->stockService->decreaseQuantity($entity->recordId);
            if (!$response->isSuccess()) {
                return $response;
            }

            return new Response(true, null, $entity->toArray());
        });
    }
}
