<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'type' => $this->faker->randomElement(['income', 'expense']),
            'category_id' => Category::factory(),
            'transaction_date' => $this->faker->date(),
            'description' => $this->faker->optional()->sentence(6),
        ];
    }
} 