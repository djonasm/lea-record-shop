<?php

namespace Acceptance;

use LeaRecordShop\Order\Model as OrderModel;
use LeaRecordShop\Stock\Model as StockModel;
use Tests\TestCase;

class SafeStockTest extends TestCase
{
    /**
     * Record id created by database seed.
     */
    CONST RECORD_ID = 123;

    /**
     * Stock id created by database seed.
     */
    CONST STOCK_ID = 88;

    /**
     * Initial stock quantity created by database seed.
     */
    CONST INIT_STOCK_QUANTITY = 50;

    /**
     * User id created by database seed.
     */
    CONST USER_ID = 66;

    public function testShouldCheckStockAvailabilityAndCreateOrder(): void
    {
        // Set
        for ($i = 0; $i < self::INIT_STOCK_QUANTITY * 2; $i++) {
            $this->post('api/v1/order', [
                'userId' => self::USER_ID,
                'recordId' => self::RECORD_ID,
            ]);
        }

        // Assertions
        $orders = OrderModel::all();
        $this->assertLessThanOrEqual(self::INIT_STOCK_QUANTITY, $orders->count());
    }
}
