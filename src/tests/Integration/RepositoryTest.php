<?php

namespace Integration;

use Database\Factories\OrderFactory;
use LeaRecordShop\Order\Model;
use Tests\IntegrationTestCase;

class RepositoryTest extends IntegrationTestCase
{
    public function testShouldUpdateOrder(): void
    {
        // Set
        $factory = $this->app->make(OrderFactory::class);
        $order = $factory->create(['userId' => 1]);
        $newClientId = 2;

        // Actions
        $this->put('api/v1/order/'.$order->id, ['userId' => $newClientId]);
        $result = Model::all()->first();

        // Assertions
        $this->assertSame($newClientId, $result->userId);
    }

    public function testShouldDeleteOrder(): void
    {
        // Set
        $factory = $this->app->make(OrderFactory::class);
        $order = $factory->create();

        // Actions
        $this->delete('api/v1/order/'.$order->id);
        $result = Model::all()->count();

        // Assertions
        $this->assertSame(0, $result);
    }
}
