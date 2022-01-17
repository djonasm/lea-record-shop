<?php

namespace LeaRecordShop\Order;

use InvalidArgumentException;

class Repository
{
    public function create(array $data): array
    {
        $entity = $this->getEntity();

        if (!$entity->fill($data)->save()) {
            throw new InvalidArgumentException('Invalid order attributes.');
        }

        return $entity->toArray();
    }

    public function update(int $id, array $data): bool
    {
        return Model::find($id)
            ->fill($data)
            ->update();
    }

    public function delete(int $id): bool
    {
        return Model::find($id)
            ->find($id)
            ->delete()
            ->update();
    }

    private function getEntity(): Model
    {
        return app(Model::class);
    }
}
