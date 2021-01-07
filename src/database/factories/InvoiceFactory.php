<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

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
            'invoice_number' => $this->faker->unique()->randomNumber(),
            'invoice_date' => Carbon::now()->format('Y-m-d H:i:s'),
            'due_date' =>Carbon::now()->format('Y-m-d H:i:s'),
            'product' => $this->faker->randomDigitNot(0),
            'department' =>$this->faker->randomDigitNot(0),
            'deduction' => $this->faker->randomFloat(2,0,100),
            'commision_value' => $this->faker->randomFloat(2,0,40),
            'vat_value' => $this->faker->randomNumber(3,false) ,
            'total' => $this->faker->numberBetween(1000,9000),
            'status' => '0',
            'created_by' => 1 ,
            'deleted_at' =>null ,
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s') ,
            'updated_at' => null,
        ];
    }
}
