<?php

namespace LeaRecordShop\Order;

use Illuminate\Support\Str;

class Identifier
{
    public function generate(): string
    {
        return (string) Str::uuid();
    }
}
