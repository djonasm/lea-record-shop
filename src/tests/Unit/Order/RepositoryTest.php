<?php

namespace Unit\Order;

use Exception;
use LeaRecordShop\Order\Model;
use LeaRecordShop\Order\Repository;
use Tests\IntegrationTestCase;

class RepositoryTest extends IntegrationTestCase
{
    public function testShouldCreateOrderWithSuccess(): void
    {
        // Set
        $repository = new Repository();

        // Avoid to use database
        $model = $this->instance(Model::class, $this->createMock(Model::class));

        $data = [
            'clientId' => 123123,
            'recordId' => 321321
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

        // Avoid to use database
        $model = $this->instance(Model::class, $this->createMock(Model::class));

        $data = [
            'clientId' => 123123,
            'recordId' => 321321
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