<?php

namespace LeaRecordShop\Stock;

use Illuminate\Support\MessageBag;
use LeaRecordShop\Response;

class Service
{
    public function decreaseQuantity(int $recordId): Response
    {
        $entity = $this->query()
            ->find(compact('recordId'));

        if ($entity->stockQuantity < 1) {
            $errors = new MessageBag(['Insufficient stock quantity.']);

            return new Response(false, $errors);
        }

        $isSuccess = $entity->decrement('stockQuantity');

        return new Response($isSuccess);
    }
}
