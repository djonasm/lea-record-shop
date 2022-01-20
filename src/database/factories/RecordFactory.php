<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LeaRecordShop\Record\Model as Record;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Record::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fromPrice = $this->faker->randomFloat(2, 1, 1000);

        return [
            'genre' => $this->faker->randomElement(['rock', 'heavy metal', 'black metal', 'death metal']),
            'release_year' => $this->faker->numberBetween(1950, 2022),
            'artist' => $this->faker->text(30),
            'name' => $this->faker->text(30),
            'label' => $this->faker->text(30),
            'trackList' => $this->randomTracks(),
            'description' => $this->faker->realText(),
            'fromPrice' => $fromPrice,
            'toPrice' => min($fromPrice, $this->faker->randomFloat(2, 1, 1000)),
        ];
    }

    private function randomTracks(): array
    {
        $numberOfTracks = $this->faker->numberBetween(2, 30);

        return array_fill(0, $numberOfTracks, $this->faker->text(20));
    }
}
