<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
           return [
            'invoice_number' => $this->faker->randomNumber(),
            'invoice_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'due_date' =>Carbon::now()->format('Y-m-d H:i:s'),
            'product' => $this->faker->sentence( 3,true),
            'section' => $this->faker->sentence( 3,true),
            'discount' => $this->faker->randomFloat(2,0,100),
            'vat_rate' => $this->faker->randomFloat(2,0,40),
            'vat_value' => $this->faker->randomNumber(3,false) ,
            'total' => $this->faker->numberBetween(1000,9000),
            'status' => 'a',
            'note' => $this->faker->sentence( 6,true),
            'user' => $this->faker->sentence(1,) ,
            'deleted_at' =>Carbon::now()->format('Y-m-d H:i:s') ,
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s') ,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ];
    }
}
