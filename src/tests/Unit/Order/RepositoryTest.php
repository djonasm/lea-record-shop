<?php

namespace Unit\Order;

use Exception;
use Illuminate\Support\MessageBag;
use LeaRecordShop\Order\Model;
use LeaRecordShop\Order\Repository;
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
            'userId' => 123123,
            'recordId' => 321321
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
            'userId' => 123123,
            'recordId' => 321321
        ];

        $errors = new MessageBag(['Invalid user id.']);

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
        $this->assertSame('Invalid user id.', $result->errors()->first());
    }
}
