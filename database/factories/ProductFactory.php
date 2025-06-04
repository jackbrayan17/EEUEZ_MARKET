<?php
namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Merchant;  // Ensure Merchant model is imported
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'category_id' => \App\Models\Category::factory(),  // assuming you have a Category model
            'price' => $this->faker->randomFloat(2, 1000, 50000),
            'description' => $this->faker->sentence,
            'stock' => $this->faker->numberBetween(10, 100),
            'user_id' => User::factory(),  // Generate a valid user ID
            'merchant_id' => Merchant::factory(),  // Use the Merchant factory to create a valid merchant ID
        ];
    }
}

