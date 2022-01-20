<?php

namespace Unit\Record;

use Exception;
use LeaRecordShop\Record\Model;
use LeaRecordShop\Record\Repository;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function testShouldCreateOrderWithSuccess(): void
    {
        // Set
        $repository = new Repository();

        // Avoid hit database
        $model = $this->instance(
            Model::class,
            $this->createMock(Model::class)
        );

        $data = [
            'genre' => 'vocal',
            'releaseYear' => 2019,
            'artist' => 'Junior Carelli',
            'name' => 'Temple of Shadows',
            'label' => 'Angra Records',
            'trackList' => json_encode(['Nova Era', 'Cavaleiro dos Zodíacos']),
            'description' => 'Best Album ever made',
            'fromPrice' => 180.00,
            'toPrice' => 119.99,
        ];

        // Expectations
        $model->expects($this->once())
            ->method('fill')
            ->with($data)
            ->willReturn($model);

        $model->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $model->expects($this->once())
            ->method('toArray')
            ->willReturn($data);

        // Actions
        $result = $repository->create($data);

        // Assertions
        $this->assertSame($data, $result);
    }

    public function testShouldThrowExceptionWhenSaveFailed(): void
    {
        // Set
        $repository = new Repository();

        // Avoid hit database
        $model = $this->instance(
            Model::class,
            $this->createMock(Model::class)
        );

        $data = [
            'genre' => 'vocal',
            'releaseYear' => 2019,
            'artist' => 'Junior Carelli',
            'name' => 'Temple of Shadows',
            'label' => 'Angra Records',
            'trackList' => json_encode(['Nova Era', 'Cavaleiro dos Zodíacos']),
            'description' => 'Best Album ever made',
            'fromPrice' => 180.00,
            'toPrice' => 119.99,
        ];

        // Expectations
        $model->expects($this->once())
            ->method('fill')
            ->with($data)
            ->willReturn($model);

        $model->expects($this->once())
            ->method('save')
            ->willReturn(false);

        $this->expectException(Exception::class);

        // Actions
        $repository->create($data);
    }
}
