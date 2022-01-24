<?php

namespace LeaRecordShop\Order;

use LeaRecordShop\Record\Service as RecordService;
use LeaRecordShop\Response;
use LeaRecordShop\Stock\Service as StockService;

class Service
{
    /**
     * @var StockService
     */
    private $stockService;

    /**
     * @var RecordService
     */
    private $recordService;

    public function __construct(
        StockService $stockService,
        RecordService $recordService
    ) {
        $this->stockService = $stockService;
        $this->recordService = $recordService;
    }

    public function isRecordAvailable(int $recordId, string $orderId): Response
    {
        $response = $this->recordService->isAvailable($recordId);
        if (!$response->isSuccess()) {
            return $response;
        }

        $response = $this->stockService->isAvailable($recordId, $orderId);
        if (!$response->isSuccess()) {
            return $response;
        }

        return new Response(true);
    }
}
