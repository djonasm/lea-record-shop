<?php

namespace LeaRecordShop\Record;

use LeaRecordShop\BaseModel;

class Model extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'records';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'genre',
        'release_year',
        'artist',
        'name',
        'label',
        'track_list',
        'description',
        'from_price',
        'to_price'
    ];
}
