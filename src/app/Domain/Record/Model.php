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
        'genre',
        'releaseYear',
        'artist',
        'name',
        'label',
        'trackList',
        'description',
        'fromPrice',
        'toPrice',
        'releaseDate',
    ];

    protected $rules = [
        'genre' => 'required|string',
        'releaseYear' => 'required|integer|between:1800,2022',
        'artist' => 'required|string',
        'name' => 'required|string',
        'label' => 'nullable|string',
        'trackList' => 'nullable|json',
        'description' => 'nullable|string',
        'fromPrice' => 'nullable|numeric',
        'toPrice' => 'required|numeric',
        'releaseDatetime' => 'nullable|date',
    ];
}
