<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Price;
use App\Models\Product; // Убедитесь, что эта строка есть для связи

class PriceFactory extends Factory
{
    protected $model = Price::class;

    public function definition(): array
    {
        return [
            // id_product будет установлен в сидере для правильной связи
            'id_product' => Product::factory(), // Это создает или использует существующий продукт
            'price' => fake()->randomFloat(2, 100, 100000), // Цена от 100.00 до 100000.00
        ];
    }
}