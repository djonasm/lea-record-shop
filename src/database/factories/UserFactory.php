<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LeaRecordShop\User\Model as User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(30),
            'email' => $this->faker->freeEmail(),
            'fiscalId' => $this->faker->text(14),
            'birthdate' => $this->faker->dateTimeBetween('-90 years'),
            'gender' => $this->faker->randomElement(['male','female','non-binary','genderqueer','agender','bigender','other']),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->streetAddress(),
            'addressNumber' => $this->faker->numberBetween(1, 10000),
            'addressState' => $this->faker->text(5),
            'neighborhood' => $this->faker->text(20),
            'city' => $this->faker->text(20),
            'zipcode' => $this->faker->text(9),
        ];
    }
}
