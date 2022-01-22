<?php

namespace Integration;

use Database\Factories\OrderFactory;
use Database\Factories\RecordFactory;
use Database\Factories\StockFactory;
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

        $record = $recordFactory->create();
        $stockFactory->create(['id' => 1, 'recordId' => $record->id, 'stockQuantity' => 1]);
        $order = $orderFactory->make(['userId' => 1, 'recordId' => $record->id]);

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

        $record = $recordFactory->create();
        $order = $orderFactory->make(['userId' => 1, 'recordId' => $record->id]);

        // Create Stock with zero quantity
        $stockFactory->create(['id' => 1, 'recordId' => $record->id, 'stockQuantity' => 0]);

        // Actions
        $this->post('api/v1/order/', $order->attributesToArray());

        // Assertions
        $this->assertResponseStatus(422);
    }
}
