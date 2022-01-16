<?php

namespace LeaRecordShop\Order;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clientId', 'recordId', 'startDate', 'endDate',
    ];
}
