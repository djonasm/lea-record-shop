<?php

namespace Unit\Record;

use Illuminate\Support\MessageBag;
use LeaRecordShop\Record\Model;
use LeaRecordShop\Record\Repository;
use LeaRecordShop\Response;
use LeaRecordShop\Stock\Repository as StockRepository;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function testShouldCreateRecordWithSuccess(): void
    {
        // Set
        $stockRepository = $this->createMock(StockRepository::class);
        $repository = new Repository($stockRepository);

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
            'stockQuantity' => 99,
        ];

        // Expectations
        $model->expects($this->once())
            ->method('fill')
            ->with($data)
            ->willReturn($model);

        $model->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $model->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $model->expects($this->once())
            ->method('toArray')
            ->willReturn($data);

        $stockRepository->expects($this->once())
            ->method('create')
            ->willReturn(new Response(true));

        // Actions
        $result = $repository->create($data);

        // Assertions
        $this->assertTrue($result->isSuccess());
        $this->assertSame($data, $result->data());
    }

    public function testShouldResponseWithErrorsWhenCreateFailed(): void
    {
        // Set
        $stockRepository = $this->createMock(StockRepository::class);
        $repository = new Repository($stockRepository);

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

        $errors = new MessageBag(['Invalid record name.']);

        // Expectations
        $model->expects($this->once())
            ->method('fill')
            ->with($data)
            ->willReturn($model);

        $model->expects($this->once())
            ->method('validate')
            ->willReturn(false);

        $model->expects($this->once())
            ->method('errors')
            ->willReturn($errors);

        // Actions
        $result = $repository->create($data);

        // Assertions
        $this->assertFalse($result->isSuccess());
        $this->assertSame('Invalid record name.', $result->errors()->first());
    }
}
