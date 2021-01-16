<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'name' => $this->faker->name,
            'email' => 'a@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$nj7ifKZYQ34/l9dW4Cz7VOCqVeU3U8UPkz2UKvj4PGQa106A3qdsO', //123456789
            'remember_token' => Str::random(10),
        ];
    }
}
