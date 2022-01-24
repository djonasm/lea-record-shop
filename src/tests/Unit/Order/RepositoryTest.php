<?php

namespace Unit\Order;

use Illuminate\Support\MessageBag;
use LeaRecordShop\Order\Identifier;
use LeaRecordShop\Order\Model;
use LeaRecordShop\Order\Repository;
use LeaRecordShop\Response;
use LeaRecordShop\Stock\Service as StockService;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function testShouldCreateOrderWithSuccess(): void
    {
        // Set
        $stockService =  $this->createMock(StockService::class);
        $identifier =  $this->createMock(Identifier::class);
        $repository = new Repository($stockService, $identifier);

        // Avoid hit database
        $model = $this->instance(
            Model::class,
            $this->createMock(Model::class)
        );

        $recordId = 321321;
        $model->recordId = $recordId;

        $orderId = '55a057de-2b60-4ca6-a906-0e38c7e0ebc1';
        $data = [
            'id' => $orderId,
            'userId' => 123123,
            'recordId' => 321321,
        ];

        // Expectations
        $identifier->expects($this->once())
            ->method('generate')
            ->willReturn($orderId);

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

        $stockService->expects($this->once())
            ->method('decrementQuantity')
            ->with($recordId)
            ->willReturn(new Response(true));

        $stockService->expects($this->once())
            ->method('isAvailable')
            ->with($recordId, $orderId)
            ->willReturn(new Response(true));

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
        $stockService =  $this->createMock(StockService::class);
        $identifier =  $this->createMock(Identifier::class);
        $repository = new Repository($stockService, $identifier);

        // Avoid hit database
        $model = $this->instance(
            Model::class,
            $this->createMock(Model::class)
        );
        $orderId = '55a057de-2b60-4ca6-a906-0e38c7e0ebc1';
        $data = [
            'id' => $orderId,
            'userId' => 123123,
            'recordId' => 321321,
        ];

        $errors = new MessageBag(['Invalid user id.']);

        // Expectations
        $identifier->expects($this->once())
            ->method('generate')
            ->willReturn($orderId);

        $stockService->expects($this->once())
            ->method('isAvailable')
            ->with(321321, $orderId)
            ->willReturn(new Response(true));

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
