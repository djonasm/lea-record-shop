<?php

namespace LeaRecordShop\Order;

use LeaRecordShop\BaseModel;

class Model extends BaseModel
{
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
        'id', 'userId', 'recordId',
    ];
}
