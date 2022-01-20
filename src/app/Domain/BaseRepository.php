<?php

namespace LeaRecordShop;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

abstract class BaseRepository
{
    abstract protected function entity(): BaseModel;

    abstract protected function query(): Builder;

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

    public function update(int $id, array $data): Response
    {
        $model = $this->query()
            ->find($id)
            ->fill($data);

        if (!$model->validate()) {
            return new Response(false, $model->errors());
        }

        if (!$model->update()) {
            return new Response(false);
        }

        return new Response(true);
    }

    public function delete(int $id): bool
    {
        return $this->query()
            ->find($id)
            ->delete();
    }
}
