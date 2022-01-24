<?php

namespace Integration;

use Database\Factories\OrderFactory;
use Database\Factories\RecordFactory;
use Database\Factories\StockFactory;
use Database\Factories\UserFactory;
use DateTime;
use Tests\IntegrationTestCase;

class ReleaseDateTest extends IntegrationTestCase
{
    public function testShouldNotCreateOrderWhenRecordHasNotBeenReleasedYet(): void
    {
        // Set
        $plusTenDaysDate = new DateTime('+ 10 days');

        $orderFactory = $this->app->make(OrderFactory::class);
        $recordFactory = $this->app->make(RecordFactory::class);
        $stockFactory = $this->app->make(StockFactory::class);
        $userFactory = $this->app->make(UserFactory::class);

        $record = $recordFactory->create([
            'releaseDatetime' => $plusTenDaysDate->format('Y-m-d H:i:s')
        ]);
        $stockFactory->create(['recordId' => $record->id, 'stockQuantity' => 1]);

        $user = $userFactory->create();
        $order = $orderFactory->make(['userId' => $user->id, 'recordId' => $record->id]);

        // Actions
        $this->post('api/v1/order/', $order->attributesToArray());

        // Assertions
        $this->assertResponseStatus(422);
    }
}
