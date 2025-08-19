<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    // Указываем явное имя таблицы
    protected $table = 'prices';

    /**
     * Получает товар, к которому относится эта цена.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}