<?php

namespace LeaRecordShop\Record;

use DateTime;
use Illuminate\Support\MessageBag;
use LeaRecordShop\Response;

class Service
{
    public function list(
        ?string $genre = null,
        ?int $releaseYear = null,
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

    public function isAvailable(int $recordId): Response
    {
        $entity = Model::find($recordId);
        $now = new DateTime('now');
        if (!$entity->releaseDatetime) {
            return new Response(true);
        }

        $releaseDate = DateTime::createFromFormat('Y-m-d H:i:s', $entity->releaseDatetime);
        if ($now > $releaseDate) {
            return new Response(true);
        }

        $errors = new MessageBag(['The record has not been released yet.']);

        return new Response(false, $errors);
    }
}
