<?php

namespace Integration;

use Database\Factories\RecordFactory;
use DateTime;
use Tests\IntegrationTestCase;

class RecordListTest extends IntegrationTestCase
{
    public function testShouldFilterRecordsByGenre(): void
    {
        // Set
        $factory = $this->app->make(RecordFactory::class);
        $factory->create(['genre' => 'rock']);
        $factory->create(['genre' => 'pop']);
        $factory->create(['genre' => 'pop']);

        // Actions
        $this->call('GET', '/api/v1/record', ['genre' => 'pop']);
        $responseData = json_decode($this->response->getContent(), true)['data'];

        // Assertions
        $this->assertCount(2, $responseData);
    }

    public function testShouldFilterRecordsByReleaseYear(): void
    {
        // Set
        $factory = $this->app->make(RecordFactory::class);

        $factory->create(['releaseYear' => 1998]);
        $factory->create(['releaseYear' => 2000]);

        // Actions
        $this->call(
            'GET',
            'api/v1/record',
            [
                'releaseYear' => 1998
            ]
        );
        $responseData = json_decode($this->response->getContent(), true)['data'];

        // Assertions
        $this->assertCount(1, $responseData);
    }

    public function testShouldFilterRecordsByArtist(): void
    {
        // Set
        $factory = $this->app->make(RecordFactory::class);

        $factory->create(['artist' => 'Nirvana']);
        $factory->create(['artist' => 'Amaranthe']);
        $factory->create(['artist' => 'Amaranthe']);

        // Actions
        $this->call(
            'GET',
            'api/v1/record',
            [
                'artist' => 'Amaranthe'
            ]
        );
        $responseData = json_decode($this->response->getContent(), true)['data'];

        // Assertions
        $this->assertCount(2, $responseData);
    }

    public function testShouldFilterRecordsByName(): void
    {
        // Set
        $factory = $this->app->make(RecordFactory::class);

        $factory->create(['name' => 'Nevermind']);
        $factory->create(['name' => 'Manist']);
        $factory->create(['name' => 'The Nexus']);

        // Actions
        $this->call(
            'GET',
            'api/v1/record',
            [
                'name' => 'The Nexus'
            ]
        );
        $responseData = json_decode($this->response->getContent(), true)['data'];

        // Assertions
        $this->assertCount(1, $responseData);
    }
}
