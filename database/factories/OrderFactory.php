<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 5);
        $totalPrice = $product ? $product->price * $quantity : 0;
        return [
            'user_id'      => User::inRandomOrder()->first()?->id ?? 1,
            'product_id'   => $product?->id ?? 1,
            'order_number' => strtoupper(Str::random(10)),
            'quantity'     => $quantity,
            'total_price'  => $totalPrice,
            'status'       => $this->faker->numberBetween(1, 4),
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
    }
}
