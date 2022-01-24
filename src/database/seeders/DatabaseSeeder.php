<?php
namespace Database\Seeders;

use Database\Factories\RecordFactory;
use Database\Factories\StockFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $recordId = 123;
        $initStockQuantity = 50;
        $userId = 66;
        $stockId = 88;

        $recordFactory = app(RecordFactory::class);
        $recordFactory->create(['id' => $recordId]);

        $stockFactory = app(StockFactory::class);
        $stockFactory->create(['id' => $stockId, 'recordId' => $recordId, 'stockQuantity' => $initStockQuantity]);

        $userFactory = app(UserFactory::class);
        $userFactory->create(['id' => $userId]);
    }
}
