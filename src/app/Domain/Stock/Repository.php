<?php

namespace LeaRecordShop\Stock;

use Illuminate\Database\Eloquent\Builder;
use LeaRecordShop\BaseModel;
use LeaRecordShop\BaseRepository;

class Repository extends BaseRepository
{
    protected function entity(): BaseModel
    {
        return app(Model::class);
    }

    protected function query(): Builder
    {
        return Model::query();
    }

    private function record(int $recordId)
    {
        return Model::where(compact('recordId'))->first();
    }
}
