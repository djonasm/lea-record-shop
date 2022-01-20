<?php

namespace LeaRecordShop;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

abstract class BaseRepository
{
    abstract protected function entity(): BaseModel;

    abstract protected function query(): Builder;

    public function create(array $data): array
    {
        $entity = $this->entity();

        if (!$entity->fill($data)->save()) {
            throw new InvalidArgumentException('Invalid order attributes.');
        }

        return $entity->toArray();
    }

    public function update(int $id, array $data): bool
    {
        return $this->query()
            ->find($id)
            ->fill($data)
            ->update();
    }

    public function delete(int $id): bool
    {
        return $this->query()
            ->find($id)
            ->delete()
            ->update();
    }
}
