<?php

namespace LeaRecordShop\Order;

class Service
{
    public function list(
        ?string $userId = null,
        ?string $startDate = null,
        ?string $endDate = null
    ): array {
        $query = Model::query();
        if ($userId) {
            $query->where(compact('userId'));
        }

        if ($startDate) {
            $query->where('createdAt', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('createdAt', '<=', $endDate);
        }

        return $query->get()->toArray();
    }
}
