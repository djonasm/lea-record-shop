<?php

namespace Tests\Integration;

use Database\Factories\OrderFactory;
use Tests\TestCase;

class OrderListTest extends TestCase
{
    public function testShouldFilterOrdersByClientId(): void
    {
        // Set
        $factory = $this->app->make(OrderFactory::class);
        $factory->create();

        $this->get('/v1/order');

        dump($this->response->getContent());
    }
}
