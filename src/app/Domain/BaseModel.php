<?php

namespace LeaRecordShop;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class BaseModel extends EloquentModel
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var MessageBag
     */
    private $errors;

    public function errors(): ?MessageBag
    {
        return $this->errors;
    }

    public function validate(): bool
    {
        $validator = Validator::make($this->toArray(), $this->rules);

        if ($validator->fails()) {
            $this->errors = $validator->errors();

            return false;
        }

        return true;
    }
}
