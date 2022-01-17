<?php

namespace LeaRecordShop\Order;

class Service
{
    public function list(
        ?string $clientId = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): array {
        $query = Model::query();
        if ($clientId) {
            $query->where(compact('clientId'));
        }

        if ($startDate && $endDate) {
            $query->where('createdAt', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('createdAt', '<=', $endDate);
        }

        return $query->get()->toArray();
    }
}
