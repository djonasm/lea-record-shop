<?php

namespace LeaRecordShop\Stock;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\MessageBag;
use LeaRecordShop\Response;

class Service
{
    public function decrementQuantity(int $recordId): Response
    {
        $entity = $this->record($recordId);
        if (!$entity || $entity->stockQuantity < 1) {
            $errors = new MessageBag(['Insufficient stock quantity.']);

            return new Response(false, $errors);
        }

        $isSuccess = $entity->decrement('stockQuantity');

        return new Response($isSuccess);
    }

    public function incrementQuantity(int $recordId): Response
    {
        $entity = $this->record($recordId);

        $isSuccess = $entity->increment('stockQuantity');

        return new Response($isSuccess);
    }

    public function isAvailable(int $recordId, string $orderId): Response
    {
        $entity = $this->record($recordId);
        $errors = new MessageBag(['Insufficient stock quantity.']);

        if ($entity->stockQuantity <= 0) {
            return new Response(false, $errors);
        }

        // Generate random stock key using stock quantity
        $randomStockKey = rand(1, $entity->stockQuantiy);
        // Reserve key, stock_2_300, means the order will try reserve stock 300 of stock id: 2.
        $key = 'stock_' . $entity->id . '_' . $randomStockKey;

        // The Cache::add method will only add the item to the cache if it does not already exist
        if (!Cache::add($key, $orderId, 5)) {
            return new Response(false, $errors);
        }

        // Small delay to check stock key, to avoid parallel add`s
        sleep(0.2);
        if (Cache::get($key) != $orderId) {
            return new Response(false, $errors);
        }

        return new Response(true);
    }

    private function record(int $recordId)
    {
        return Model::where(compact('recordId'))->first();
    }
}
