<?php

namespace App\Http\Controllers;

use App\Models\Group;    // Импортируем модель Group
use App\Models\Product;  // Импортируем модель Product
use Illuminate\Http\Request; // Импортируем класс Request для работы с запросами
use Illuminate\Pagination\LengthAwarePaginator; // Импортируем для ручной пагинации коллекций

class CatalogController extends Controller
{
    /**
     * Отображает главную страницу каталога:
     * - Группы первого уровня с количеством товаров (включая подгруппы).
     * - Все товары с сортировкой и пагинацией.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. Получаем группы первого уровня (id_parent = 0)
        // Используем eager loading (with) для предварительной загрузки связанных данных
        // Это помогает избежать N+1 проблемы с запросами к БД.
        $topLevelGroups = Group::where('id_parent', 0)
                                ->with(['products.price', 'children.products.price']) // Загружаем продукты с ценами и дочерние группы с их продуктами и ценами
                                ->get(); // Получаем все группы первого уровня

        // 2. Получаем все товары для отображения на главной странице
        $productsQuery = Product::with('price', 'group'); // Загружаем связанные цену и группу для каждого товара

        // 3. Реализация сортировки товаров
        $sortBy = $request->query('sort_by', 'name'); // По умолчанию сортируем по названию
        $sortOrder = $request->query('sort_order', 'asc'); // По умолчанию по возрастанию

        if ($sortBy === 'price') {
            // Если сортировка по цене, нужно присоединить таблицу prices
            $productsQuery->join('prices', 'products.id', '=', 'prices.id_product')
                          ->orderBy('prices.price', $sortOrder)
                          ->select('products.*'); // Важно: после join выбрать все столбцы из products
        } elseif ($sortBy === 'name') {
            // Сортировка по названию товара
            $productsQuery->orderBy('name', $sortOrder);
        }

        // 4. Пагинация товаров
        $perPage = $request->query('per_page', 12); // Получаем per_page из запроса, по умолчанию 12
        $products = $productsQuery->paginate($perPage); // Используем perPage
        
        // Передаем данные в представление
        return view('catalog.index', [
            'topLevelGroups' => $topLevelGroups, // Группы первого уровня
            'products' => $products,             // Отсортированные и пагинированные товары
            'sortBy' => $sortBy,                 // Текущий параметр сортировки
            'sortOrder' => $sortOrder,           // Текущий порядок сортировки
            'perPage' => $perPage,               // Текущее количество товаров на страницу
        ]);
    }

    /**
     * Метод для отображения товаров и подгрупп для выбранной группы.
     * Будет реализован позже.
     */
    public function showGroup(Group $group, Request $request)
    {
        // 1. Получаем дочерние группы для текущей группы.
        // Используем eager loading для подсчета товаров в этих подгруппах.
        $subGroups = $group->children()->with(['products.price', 'children.products.price'])->get();

        // 2. Получаем все товары в текущей группе и ее подгруппах.
        // Аксессор all_products в модели Group уже делает это рекурсивно.
        $allProductsInGroup = $group->all_products;

        // 3. Реализация сортировки для товаров в группе
        $sortBy = $request->query('sort_by', 'name');
        $sortOrder = $request->query('sort_order', 'asc');

        if ($sortBy === 'price') {
            // Сортировка коллекции по цене.
            // sortBy работает с замыканием, чтобы получить доступ к связанной цене.
            $sortedProducts = $allProductsInGroup->sortBy(function ($product) {
                return $product->price->price ?? 0; // Используем 0, если цена не найдена
            }, SORT_REGULAR, $sortOrder === 'desc'); // SORT_REGULAR для обычного сравнения, true для убывания
        } elseif ($sortBy === 'name') {
            // Сортировка коллекции по названию товара.
            $sortedProducts = $allProductsInGroup->sortBy('name', SORT_REGULAR, $sortOrder === 'desc');
        } else {
            // Если сортировка не указана или неверна, используем исходную коллекцию
            $sortedProducts = $allProductsInGroup;
        }

        // 4. Ручная пагинация для коллекции (не для Query Builder)
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Получаем текущую страницу из запроса
        $perPage = $request->query('per_page', 12); // Получаем per_page из запроса, по умолчанию 12
        $currentPageItems = $sortedProducts->slice(($currentPage - 1) * $perPage, $perPage)->all(); // Выбираем элементы для текущей страницы
        $products = new LengthAwarePaginator($currentPageItems, count($sortedProducts), $perPage);
        $products->setPath($request->url()); // Устанавливаем базовый URL для ссылок пагинации

        // Добавляем параметр per_page к ссылкам пагинации
        $products->appends(['per_page' => $perPage, 'sort_by' => $sortBy, 'sort_order' => $sortOrder]);

        // 5. Генерируем хлебные крошки для текущей группы
        $breadcrumbs = [];
        $currentBreadcrumbGroup = $group;

        while ($currentBreadcrumbGroup) {
            // Добавляем родительскую группу в начало массива хлебных крошек
            array_unshift($breadcrumbs, [
                'name' => $currentBreadcrumbGroup->name,
                'url' => route('catalog.group', $currentBreadcrumbGroup->id),
            ]);
            // Переходим к родительской группе
            $currentBreadcrumbGroup = $currentBreadcrumbGroup->parent;
        }

        return view('catalog.group', [
            'currentGroup' => $group,      // Текущая выбранная группа
            'subGroups' => $subGroups,     // Ее дочерние группы
            'products' => $products,       // Отсортированные и пагинированные товары в этой группе и подгруппах
            'sortBy' => $sortBy,           // Текущий параметр сортировки
            'sortOrder' => $sortOrder,     // Текущий порядок сортировки
            'breadcrumbs' => $breadcrumbs, // Сформированные хлебные крошки
            'perPage' => $perPage,         // Текущее количество товаров на страницу

        ]);
    }

    public function showProduct(Product $product)
    {
        // 1. Загружаем связанную цену и группу товара.
        // Eager loading here prevents N+1 queries.
        $product->load('price', 'group');

        // 2. Генерируем хлебные крошки
        $breadcrumbs = [];
        $currentGroup = $product->group; // Начинаем с группы, к которой принадлежит товар

        // Идем вверх по иерархии групп, пока не достигнем группы без родителя (id_parent = 0)
        while ($currentGroup) {
            // Добавляем текущую группу в начало массива (чтобы порядок был от родителя к потомку)
            array_unshift($breadcrumbs, [
                'name' => $currentGroup->name,
                'url' => route('catalog.group', $currentGroup->id),
            ]);
            // Переходим к родительской группе
            $currentGroup = $currentGroup->parent;
        }

        // 3. Добавляем сам товар в конец хлебных крошек
        // Для товара не нужен URL в хлебных крошках, так как он уже текущий активный элемент
        $breadcrumbs[] = [
            'name' => $product->name,
            'url' => '#', // Или route('catalog.product', $product->id), если хотите сделать его кликабельным (но обычно последний элемент не кликабелен)
        ];

        return view('catalog.product', [
            'product' => $product,         // Сам товар
            'breadcrumbs' => $breadcrumbs, // Сформированные хлебные крошки
        ]);
    }
}