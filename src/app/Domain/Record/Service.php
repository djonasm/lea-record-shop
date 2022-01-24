<?php

namespace LeaRecordShop\Record;

use DateTime;
use Illuminate\Support\MessageBag;
use LeaRecordShop\Response;

class Service
{
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
