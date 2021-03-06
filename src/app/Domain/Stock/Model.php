<?php

namespace LeaRecordShop\Stock;

use LeaRecordShop\BaseModel;

class Model extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recordId', 'stockQuantity',
    ];

    protected $rules = [
        'recordId' => 'required|exists:LeaRecordShop\Record\Model,id',
        'stockQuantity' => 'required|integer',
    ];
}
