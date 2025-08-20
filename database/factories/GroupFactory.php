<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Group;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            // id_parent будет генерироваться в сидере, если нужен конкретный родитель
            // Или можно сделать его случайным, но это может привести к невалидным связям
            'id_parent' => 0, // По умолчанию 0, если нет родителя
            'name' => fake()->unique()->word() . ' Group',
        ];
    }
}