<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->unique()->words(2,true),
            'created_by'=>1,
            'img'=>null,
            'description'=>$this->faker->sentences(3,true),
            'created_at'=>now(),
            'updated_at'=>now(),
            'department_id'=>$this->faker->regexify('/^[6-9]{1}$/'),
            'price'=>$this->faker->regexify('/^[0-9]{4}$/'),

        ];
    }
}
