<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController; // Добавляем импорт нашего контроллера

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Маршрут для главной страницы каталога
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');

// Маршрут для страницы конкретной группы товаров
Route::get('/group/{group}', [CatalogController::class, 'showGroup'])->name('catalog.group');

// Маршрут для страницы детализации товара
Route::get('/product/{product}', [CatalogController::class, 'showProduct'])->name('catalog.product');
