<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Product&Customer;
use App\Models\Product;
use App\Models\Transaction;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'customer_id' => Customer::factory(),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'total' => $this->faker->randomFloat(0, 0, 9999999999.),
            'status' => $this->faker->randomElement(["pending","successful","failed"]),
            'snap_token' => $this->faker->word(),
            'product&_customer_id' => Product&Customer::factory(),
        ];
    }
}
