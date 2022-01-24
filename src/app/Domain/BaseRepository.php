<?php

namespace LeaRecordShop;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use LeaRecordShop\Stock\Model;

abstract class BaseRepository
{
    abstract protected function entity(): BaseModel;

    abstract protected function query(): Builder;

    public function first($id): BaseModel
    {
        return $this->query()->first($id);
    }

    public function create(array $data): Response
    {
        $entity = $this->entity()->fill($data);

        if (!$entity->validate()) {
            return new Response(false, $entity->errors());
        }

        if (!$entity->save()) {
            return new Response(false);
        }

        return new Response(true, null, $entity->toArray());
    }

    /**
     * @param $id string|int
     */
    public function update($id, array $data): Response
    {
        $entity = $this->query()
            ->find($id)
            ->fill($data);

        if (!$entity->validate()) {
            return new Response(false, $entity->errors());
        }

        if (!$entity->update()) {
            return new Response(false);
        }

        return new Response(true);
    }

    /**
     * @param $id string|int
     */
    public function delete($id): ?bool
    {
        return $this->query()
            ->find($id)
            ->delete();
    }
}
