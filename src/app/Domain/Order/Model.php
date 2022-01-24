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
        'id',
        'userId',
        'recordId',
    ];

    protected $rules = [
        'userId' => 'required|exists:LeaRecordShop\User\Model,id',
        'recordId' => 'required|exists:LeaRecordShop\Record\Model,id',
    ];

    public function getKeyType()
    {
        return 'string';
    }

    public function getIncrementing()
    {
        return false;
    }
}
