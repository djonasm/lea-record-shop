<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LeaRecordShop\Order\Model as Order;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'userId' => $this->faker->randomNumber(),
            'recordId' => $this->faker->randomNumber(),
        ];
    }
}
