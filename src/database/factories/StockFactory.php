<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LeaRecordShop\Stock\Model as Stock;

class StockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'recordId' => $this->faker->randomNumber(),
            'stockQuantity' => $this->faker->randomNumber(),
        ];
    }
}
