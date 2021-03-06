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

    public function list(
        ?string $genre = null,
        ?int $releaseYear = null,
        ?string $artist = null,
        ?string $name = null
    ): array {
        $query = Model::query();
        if ($genre) {
            $query->where(compact('genre'));
        }

        if ($releaseYear) {
            $query->where(compact('releaseYear'));
        }

        if ($artist) {
            $query->where(compact('artist'));
        }

        if ($name) {
            $query->where(compact('name'));
        }

        return $query->get()->toArray();
    }

    public function create(array $data): Response
    {
        $entity = $this->entity()->fill($data);

        if (!$entity->validate()) {
            return new Response(false, $entity->errors());
        }

        return DB::transaction(
            function () use ($entity, $data) {
                if (!$entity->save()) {
                    return new Response(false);
                }

                $response = $this->stockRepository->create($data);
                if (!$response->isSuccess()) {
                    return $response;
                }

                return new Response(true, null, $entity->toArray());
            }
        );
    }

    public function update($id, array $data): Response
    {
        $entity = $this->query()
            ->find($id)
            ->fill($data);

        if (!$entity->validate()) {
            return new Response(false, $entity->errors());
        }

        // Simplify update when stock will not update
        if (!$data['stockQuantity']) {
            parent::update($id, $data);
        }

        return $this->updateRecordAndStock($entity, $id, $data);
    }

    protected function entity(): BaseModel
    {
        return app(Model::class);
    }

    protected function query(): Builder
    {
        return Model::query();
    }

    private function updateRecordAndStock($entity, int $id, array $data): Response
    {
        return DB::transaction(
            function () use ($entity, $id, $data) {
                if (!$entity->update()) {
                    return new Response(false);
                }

                $response = $this->stockRepository->update($id, $data);
                if (!$response->isSuccess()) {
                    return $response;
                }

                return new Response(true, null, $entity->toArray());
            }
        );
    }
}
