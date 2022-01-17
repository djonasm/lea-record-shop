<?php

namespace LeaRecordShop\Order;

class Service
{
    public function list(
        ?string $clientId = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): array {
        return Model::all()->toArray();
    }
}
