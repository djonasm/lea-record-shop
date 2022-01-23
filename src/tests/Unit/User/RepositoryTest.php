<?php

namespace Unit\User;

use Illuminate\Support\MessageBag;
use LeaRecordShop\User\Model;
use LeaRecordShop\User\Repository;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function testShouldCreateUserWithSuccess(): void
    {
        // Set
        $repository = new Repository();

        // Avoid hit database
        $model = $this->instance(
            Model::class,
            $this->createMock(Model::class)
        );

        $recordId = 321321;
        $model->recordId = $recordId;

        $data = [
            'name' => 'John Days',
            'email' => 'johndays@johndays.com',
            'gender' => 'other',
            'address' => 'Rua Joao Dias',
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

    public function testShouldResponseWithErrorsWhenCreateFailed(): void
    {
        // Set
        $repository = new Repository();

        // Avoid hit database
        $model = $this->instance(
            Model::class,
            $this->createMock(Model::class)
        );

        $data = [
            'name' => 'John Days',
            'email' => 'johndays@johndays.com',
            'gender' => 'other',
            'address' => 123,
        ];

        $errors = new MessageBag(['Invalid address parameter.']);

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
        $this->assertSame('Invalid address parameter.', $result->errors()->first());
    }
}
