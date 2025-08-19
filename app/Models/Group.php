<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // Указываем явное имя таблицы, так как оно не соответствует стандартному именованию Laravel (group -> groups)
    protected $table = 'groups';

    /**
     * Получает товары, которые напрямую принадлежат этой группе.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'id_group', 'id');
    }

    /**
     * Получает дочерние группы для текущей группы.
     */
    public function children()
    {
        return $this->hasMany(Group::class, 'id_parent', 'id');
    }

    /**
     * Получает родительскую группу для текущей группы.
     */
    public function parent()
    {
        return $this->belongsTo(Group::class, 'id_parent', 'id');
    }

    /**
     * Аксессор для получения всех товаров в текущей группе и ее подгруппах (рекурсивно).
     * Это свойство будет доступно как $group->all_products.
     */
    public function getAllProductsAttribute()
    {
        $products = collect(); // Создаем пустую коллекцию для сбора товаров

        // Добавляем товары, напрямую принадлежащие этой группе
        foreach ($this->products as $product) {
            $products->push($product);
        }

        // Рекурсивно добавляем товары из всех дочерних групп
        foreach ($this->children as $child) {
            $products = $products->merge($child->all_products);
        }

        return $products;
    }

    /**
     * Аксессор для получения общего количества товаров в текущей группе и ее подгруппах.
     * Это свойство будет доступно как $group->total_products_count.
     */
    public function getTotalProductsCountAttribute()
    {
        // Используем аксессор all_products для подсчета
        return $this->all_products->count();
    }
}