<?php

namespace Integration;

use Database\Factories\OrderFactory;
use LeaRecordShop\Order\Model;
use Tests\IntegrationTestCase;

class OrderRepository extends IntegrationTestCase
{
    public function testShouldUpdateOrder()
    {
        // Set
        $factory = $this->app->make(OrderFactory::class);
        $order = $factory->create(['clientId' => 1]);
        $newClientId = 2;

        // Actions
        $this->put('api/v1/order/'.$order->id, ['clientId' => $newClientId]);
        $result = Model::all()->first();

        $this->assertSame($newClientId, $result->clientId);
    }

    public function testShouldDeleteOrder()
    {
        // Set
        $factory = $this->app->make(OrderFactory::class);
        $order = $factory->create();

        // Actions
        $this->delete('api/v1/order/'.$order->id);
        $result = Model::all()->count();

        $this->assertSame(0, $result);
    }
}
