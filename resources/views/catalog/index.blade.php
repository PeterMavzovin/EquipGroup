@extends('layouts.app') {{-- Расширяем базовый шаблон --}}

@section('content') {{-- Определяем секцию content --}}
    <h1 class="mb-4">Каталог товаров</h1>

    <div class="row">
        {{-- Колонка для групп товаров --}}
        <div class="col-md-3">
            <h3 class="mb-3">Группы товаров</h3>
            <ul class="list-group">
                @foreach ($topLevelGroups as $group)
                    <li class="list-group-item group-list-item d-flex justify-content-between align-items-center">
                        {{-- Ссылка на страницу группы --}}
                        <a href="{{ route('catalog.group', $group->id) }}">
                            {{ $group->name }}
                        </a>
                        {{-- Общее количество товаров в группе и подгруппах --}}
                        <span class="badge bg-primary rounded-pill">{{ $group->total_products_count }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Колонка для списка товаров --}}
        <div class="col-md-9">
            <h3 class="mb-3">Все товары</h3>

            {{-- Форма для сортировки --}}
            <div class="mb-3">
                <label for="sort" class="form-label">Сортировка:</label>
                <div class="btn-group" role="group" aria-label="Сортировка товаров">
                    <a href="{{ route('catalog.index', ['sort_by' => 'name', 'sort_order' => 'asc']) }}"
                       class="btn btn-outline-secondary {{ $sortBy === 'name' && $sortOrder === 'asc' ? 'active' : '' }}">Название (А-Я)</a>
                    <a href="{{ route('catalog.index', ['sort_by' => 'name', 'sort_order' => 'desc']) }}"
                       class="btn btn-outline-secondary {{ $sortBy === 'name' && $sortOrder === 'desc' ? 'active' : '' }}">Название (Я-А)</a>
                    <a href="{{ route('catalog.index', ['sort_by' => 'price', 'sort_order' => 'asc']) }}"
                       class="btn btn-outline-secondary {{ $sortBy === 'price' && $sortOrder === 'asc' ? 'active' : '' }}">Цена (возр.)</a>
                    <a href="{{ route('catalog.index', ['sort_by' => 'price', 'sort_order' => 'desc']) }}"
                       class="btn btn-outline-secondary {{ $sortBy === 'price' && $sortOrder === 'desc' ? 'active' : '' }}">Цена (убыв.)</a>
                </div>
            </div>

            {{-- Отображение товаров --}}
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-md-4">
                        <div class="card product-card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('catalog.product', $product->id) }}">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                {{-- Проверяем наличие цены, прежде чем ее выводить --}}
                                <p class="card-text">Цена:
                                    <strong>
                                        {{ number_format($product->price->price ?? 0, 2, ',', ' ') }} руб.
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Сообщение, если товаров нет --}}
                    <div class="col-12">
                        <p class="alert alert-info">Нет товаров для отображения.</p>
                    </div>
                @endforelse
            </div>

            {{-- Пагинация --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination::bootstrap-5') }} {{-- Используем тему Bootstrap 5 для пагинации --}}
            </div>
        </div>
    </div>
@endsection