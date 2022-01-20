<?php

namespace LeaRecordShop\Record;

class Service
{
    public function list(
        ?string $genre = null,
        ?string $releaseYear = null,
        ?string $artist = null,
        ?string $name = null
    ): array {
        $query = Model::query();
        if ($genre) {
            $query->where(compact('genre'));
        }

        if ($releaseYear) {
            $query->where(compact('releaseYear'));
        }

        if ($artist) {
            $query->where(compact('artist'));
        }

        if ($name) {
            $query->where(compact('name'));
        }

        return $query->get()->toArray();
    }
}
