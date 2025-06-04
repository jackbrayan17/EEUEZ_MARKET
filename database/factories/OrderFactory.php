<?php
namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'product_id' => 1,  // Assuming you have a product model
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(1000, 10000),
            'status' => 'pending',
            'user_id' => \App\Models\User::factory(),
            'address' => $this->faker->address,
        ];
    }
}
