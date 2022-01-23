<?php

namespace Integration;

use Database\Factories\OrderFactory;
use Database\Factories\RecordFactory;
use Database\Factories\StockFactory;
use Database\Factories\UserFactory;
use LeaRecordShop\Order\Model as OrderModel;
use LeaRecordShop\Record\Model as RecordModel;
use LeaRecordShop\Stock\Model as StockModel;
use Tests\IntegrationTestCase;

class RepositoryTest extends IntegrationTestCase
{
    public function testShouldUpdateOrder(): void
    {
        // Set
        $orderFactory = $this->app->make(OrderFactory::class);
        $recordFactory = $this->app->make(RecordFactory::class);
        $userFactory = $this->app->make(UserFactory::class);

        $record = $recordFactory->create();
        $user = $userFactory->create();
        $newUser = $userFactory->create();
        $order = $orderFactory->create(['userId' => $user->id, 'recordId' => $record]);

        // Actions
        $this->put('api/v1/order/'.$order->id, ['userId' => $newUser->id]);
        $result = OrderModel::all()->first();

        // Assertions
        $this->assertSame($newUser->id, $result->userId);
    }

    public function testShouldUpdateRecord(): void
    {
        // Set
        $recordFactory = $this->app->make(RecordFactory::class);
        $stockFactory = $this->app->make(StockFactory::class);

        $record = $recordFactory->create(['genre' => 'vocal']);
        $stockFactory->create(['recordId' => $record->id]);

        // Actions
        $this->put('api/v1/record/'.$record->id, ['genre' => 'pop', 'stockQuantity' => 123]);
        $recordResult = RecordModel::all()->first();
        $stockResult = StockModel::all()->first();

        // Assertions
        $this->assertSame('pop', $recordResult->genre);
        $this->assertSame(123, $stockResult->stockQuantity);
    }

    public function testShouldDeleteOrder(): void
    {
        // Set
        $orderFactory = $this->app->make(OrderFactory::class);
        $recordFactory = $this->app->make(RecordFactory::class);
        $stockFactory = $this->app->make(StockFactory::class);

        $record = $recordFactory->create();
        $order = $orderFactory->create(['userId' => 1, 'recordId' => $record]);
        $stockFactory->create(['stockQuantity' => 1, 'recordId' => $record]);

        // Actions
        $this->delete('api/v1/order/'.$order->id);
        $result = OrderModel::all()->count();

        // Assertions
        $this->assertSame(0, $result);
    }
}
