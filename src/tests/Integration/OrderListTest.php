<?php

namespace Tests\Integration;

use Database\Factories\OrderFactory;
use Tests\IntegrationTestCase;

class OrderListTest extends IntegrationTestCase
{
    public function testShouldFilterOrdersByClientId(): void
    {
        // Set
        $factory = $this->app->make(OrderFactory::class);
        $factory->create(['clientId' => 1]);
        $factory->create(['clientId' => 1]);
        $factory->create(['clientId' => 2]);

        // Actions
        $this->call('GET', '/v1/order', ['clientId' => 2]);
        $responseData = json_decode($this->response->getContent())['data'];

        // Assertions
        $this->assertCount(1, $responseData);
    }
}
