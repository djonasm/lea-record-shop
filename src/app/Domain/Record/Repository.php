<?php

namespace LeaRecordShop\Record;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use LeaRecordShop\BaseModel;
use LeaRecordShop\BaseRepository;
use LeaRecordShop\Response;
use LeaRecordShop\Stock\Repository as StockRepository;

class Repository extends BaseRepository
{
    /**
     * @var StockRepository
     */
    private $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
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

            $response = $this->stockRepository->create($data);
            if (!$response->isSuccess()) {
                return $response;
            }

            return new Response(true, null, $entity->toArray());
        });
    }

    public function update(int $id, array $data): Response
    {
        $entity = $this->query()
            ->find($id)
            ->fill($data);

        if (!$entity->validate()) {
            return new Response(false, $entity->errors());
        }

        return DB::transaction(function() use ($entity, $id, $data) {
            if (!$entity->update()) {
                return new Response(false);
            }

            $response = $this->stockRepository->update($id, $data);
            if (!$response->isSuccess()) {
                return $response;
            }

            return new Response(true, null, $entity->toArray());
        });
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
