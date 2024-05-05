<?php

namespace Database\Factories;

use App\Models\Releveur;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReleveurFactory extends Factory
{
    protected $model = Releveur::class;

    public function definition(): array
    {
        return [
            'serialNumber' => $this->faker->unique()->randomNumber(),
            'fullName' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'birthday' => '2009-02-15',
            'email' => $this->faker->unique()->safeEmail,
            'description' => $this->faker->sentence,
        ];
    }
}