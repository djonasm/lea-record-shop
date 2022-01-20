<?php

namespace Unit\Record;

use Exception;
use Illuminate\Support\MessageBag;
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
            ->method('validate')
            ->willReturn(true);

        $model->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $model->expects($this->once())
            ->method('toArray')
            ->willReturn($data);

        // Actions
        $result = $repository->create($data);

        // Assertions
        $this->assertTrue($result->isSuccess());
        $this->assertSame($data, $result->data());
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
