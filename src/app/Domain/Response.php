<?php

namespace LeaRecordShop;

use Illuminate\Support\MessageBag;

class Response
{
    /**
     * @var bool
     */
    private $isSuccess;

    /**
     * @var MessageBag
     */
    private $errors;

    /**
     * @var array
     */
    private $data;

    public function __construct(bool $isSuccess, ?MessageBag $errors = null, ?array $data = null)
    {
        $this->isSuccess = $isSuccess;
        $this->errors = $errors;
        $this->data = $data;
    }

    public function errors(): ?MessageBag
    {
        return $this->errors;
    }

    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    public function data(): ?array
    {
        return $this->data;
    }
}
