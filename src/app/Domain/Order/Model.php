<?php

namespace LeaRecordShop\Order;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'clientId', 'recordId',
    ];
}
