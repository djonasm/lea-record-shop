<?php

namespace Integration;

use Database\Factories\OrderFactory;
use DateTime;
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
        $responseData = json_decode($this->response->getContent(), true)['data'];

        // Assertions
        $this->assertCount(1, $responseData);
    }

    public function testShouldFilterOrdersByPeriodDate(): void
    {
        // Set
        $factory = $this->app->make(OrderFactory::class);

        $minusTwoDaysDate = new DateTime('- 2 days');
        $minusThreeDaysDate = new DateTime('- 3 days');
        $minusTenDaysDate = new DateTime('- 10 days');

        $factory->create(['createdAt' => $minusTwoDaysDate->format(DateTime::ATOM)]);
        $factory->create(['createdAt' => $minusTenDaysDate->format(DateTime::ATOM)]);

        // Actions
        $this->call(
            'GET',
            '/v1/order',
            [
                'startDate' => $minusTenDaysDate->format(DateTime::ATOM),
                'endDate' => $minusThreeDaysDate->format(DateTime::ATOM),
            ]
        );
        $responseData = json_decode($this->response->getContent(), true)['data'];

        // Assertions
        $this->assertCount(1, $responseData);
    }
}
