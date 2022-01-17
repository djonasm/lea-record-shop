<?php

namespace LeaRecordShop\Order;

class Service
{
    public function list(
        ?string $clientId = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): array {
        $query = [];
        if ($clientId) {
            $query = array_merge($query, compact('clientId'));
        }

        if ($startDate) {
            $query = array_merge($query, compact('startDate'));
        }

        if ($endDate) {
            $query = array_merge($query, compact('endDate'));
        }

        return Model::where($query)->get()->toArray();
    }
}
