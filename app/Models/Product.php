<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Указываем явное имя таблицы
    protected $table = 'products';
    protected $fillable = ['id_group', 'name'];

    public $timestamps = false;
    /**
     * Получает группу, к которой принадлежит товар.
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id');
    }

    /**
     * Получает цену, связанную с этим товаром.
     */
    public function price()
    {
        return $this->hasOne(Price::class, 'id_product', 'id');
    }
}