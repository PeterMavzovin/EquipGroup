<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Group;
use App\Models\Product;
use App\Models\Price; // Добавьте эту строку
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create(); // Создать 10 тестовых пользователей

        // Создаем 5 групп
        Group::factory(5)->create()->each(function ($group) {
            // Для каждой группы создаем по 10 продуктов
            Product::factory(10)->create([
                'id_group' => $group->id,
            ])->each(function ($product) {
                // Для каждого продукта создаем 3 цены
                Price::factory(3)->create([
                    'id_product' => $product->id,
                ]);
            });
        });
    }
}