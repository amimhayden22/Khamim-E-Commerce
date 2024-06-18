<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

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
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'price' => $this->faker->randomFloat(0, 0, 9999999999.),
            'stock' => $this->faker->numberBetween(-10000, 10000),
            'image' => $this->faker->word(),
            'description' => $this->faker->text(),
            'status' => $this->faker->randomElement(["active","inactive"]),
        ];
    }
}
