<?php

namespace Integration;

use Database\Factories\OrderFactory;
use Database\Factories\RecordFactory;
use Database\Factories\StockFactory;
use Database\Factories\UserFactory;
use LeaRecordShop\Stock\Model;
use Tests\IntegrationTestCase;

class StockValidationTest extends IntegrationTestCase
{
    public function testShouldDecreaseStockWhenCreateOrder(): void
    {
        // Set
        $orderFactory = $this->app->make(OrderFactory::class);
        $recordFactory = $this->app->make(RecordFactory::class);
        $stockFactory = $this->app->make(StockFactory::class);
        $userFactory = $this->app->make(UserFactory::class);

        $record = $recordFactory->create();
        $user = $userFactory->create();
        $stockFactory->create([
            'id' => 1,
            'recordId' => $record->id,
            'stockQuantity' => 1
        ]);
        $order = $orderFactory->make([
            'userId' => $user->id,
            'recordId' => $record->id
        ]);

        // Actions
        $this->post('api/v1/order/', $order->attributesToArray());
        $stock = Model::find(1);

        // Assertions
        $this->assertSame(0, $stock->stockQuantity);
    }

    public function testShouldReturnFailedResponseToCreateOrderWhenStockIsInsufficient(): void
    {
        // Set
        $orderFactory = $this->app->make(OrderFactory::class);
        $recordFactory = $this->app->make(RecordFactory::class);
        $stockFactory = $this->app->make(StockFactory::class);
        $userFactory = $this->app->make(UserFactory::class);

        $record = $recordFactory->create();
        $user = $userFactory->create();
        $order = $orderFactory->make(['userId' => 1, 'recordId' => $record->id]);

        // Create Stock with zero quantity
        $stockFactory->create(['id' => $user->id, 'recordId' => $record->id, 'stockQuantity' => 0]);

        // Actions
        $this->post('api/v1/order/', $order->attributesToArray());

        // Assertions
        $this->assertResponseStatus(422);
    }

    public function testShouldReleaseStockWhenOrderWasDeleted(): void
    {
        // Set
        $orderFactory = $this->app->make(OrderFactory::class);
        $recordFactory = $this->app->make(RecordFactory::class);
        $stockFactory = $this->app->make(StockFactory::class);
        $userFactory = $this->app->make(UserFactory::class);

        $record = $recordFactory->create();
        $user = $userFactory->create();
        $stockFactory->create([
            'id' => 1,
            'recordId' => $record->id,
            'stockQuantity' => 1
        ]);
        $order = $orderFactory->create([
            'userId' => $user->id,
            'recordId' => $record->id
        ]);

        // Actions
        $this->delete('api/v1/order/'.$order->id);
        $stock = Model::find(1);

        // Assertions
        $this->assertSame(2, $stock->stockQuantity);
    }

    public function testShouldReleaseStockWhenOrderWasUpdated(): void
    {
        // Set
        $orderFactory = $this->app->make(OrderFactory::class);
        $recordFactory = $this->app->make(RecordFactory::class);
        $stockFactory = $this->app->make(StockFactory::class);
        $userFactory = $this->app->make(UserFactory::class);

        $record = $recordFactory->create();
        $newRecord = $recordFactory->create();
        $user = $userFactory->create();

        $stockFactory->create([
            'id' => 1,
            'recordId' => $record->id,
            'stockQuantity' => 1
        ]);
        $stockFactory->create([
            'id' => 2,
            'recordId' => $newRecord->id,
            'stockQuantity' => 1
        ]);
        $order = $orderFactory->create([
            'userId' => $user->id,
            'recordId' => $record->id
        ]);

        // Actions
        $this->put('api/v1/order/'.$order->id, ['recordId' => $newRecord->id]);
        $recordStock = Model::find(1);
        $newRecordStock = Model::find(2);

        // Assertions
        $this->assertSame(2, $recordStock->stockQuantity);
        $this->assertSame(0, $newRecordStock->stockQuantity);
    }
}
