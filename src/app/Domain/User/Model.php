<?php

namespace LeaRecordShop\User;

use Illuminate\Database\Eloquent\SoftDeletes;
use LeaRecordShop\BaseModel;

class Model extends BaseModel
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'fiscalId',
        'birthdate',
        'gender',
        'phone',
        'address',
        'addressNumber',
        'addressState',
        'neighborhood',
        'city',
        'zipcode',
    ];

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|unique|email',
        'fiscalId' => 'required|unique|string',
        'birthdate' => 'required|date',
        'gender' => 'nullable|in:male,female,non-binary,genderqueer,agender,bigender,other',
        'phone' => 'nullable|string|between:10,11',
        'address' => 'nullable|string',
        'addressNumber' => 'nullable|integer',
        'addressState' => 'nullable|string|size:2',
        'neighborhood' => 'nullable|string',
        'city' => 'nullable|string',
        'zipcode' => 'nullable|string',
    ];
}
