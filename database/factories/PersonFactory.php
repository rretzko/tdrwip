<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Person::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $sequence = 0;
        return [
            'user_id' => ++$sequence,
            'first' => $this->faker->firstName(),
            'middle' => $this->faker->firstName(),
            'last' => $this->faker->lastName(),
            'pronoun_id' => rand(1,9),
            'honorific_id' => rand(1,6),
        ];
    }
}
