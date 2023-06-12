<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->text(191),
            'data' => now(),
            'valor' => $this->faker->randomFloat(2),
            'users_id' => $this->faker->numberBetween(1, User::count()),
        ];
    }
}
