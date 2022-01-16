<?php

namespace Tests\Integration;

use Tests\TestCase;

class OrderListTest extends TestCase
{
    public function testShouldFilterOrdersByClientId(): void
    {
        $this->get('/v1/order');

        dump($this->response->getContent());
    }
}
