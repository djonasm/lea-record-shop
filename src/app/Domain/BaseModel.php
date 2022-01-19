<?php

namespace LeaRecordShop;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class BaseModel extends EloquentModel
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}
