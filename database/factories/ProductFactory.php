<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Group; // Убедитесь, что эта строка есть для связи

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            // id_group будет установлен в сидере для правильной связи
            'id_group' => Group::factory(), // Это создает или использует существующую группу
            'name' => fake()->unique()->sentence(3),
        ];
    }
}