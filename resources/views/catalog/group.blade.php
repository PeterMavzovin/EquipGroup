@extends('layouts.app')

@section('content')
    {{-- Хлебные крошки --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumbs">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Главная</a></li>
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($loop->last)
                    {{-- Последний элемент в хлебных крошках (текущая группа) --}}
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                @else
                    {{-- Промежуточные элементы хлебных крошек --}}
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>

    <h1 class="mb-4">{{ $currentGroup->name }} (Группа)</h1>

    {{-- Отображение подгрупп --}}
    @if ($subGroups->isNotEmpty())
        <h3 class="mb-3">Подгруппы</h3>
        <ul class="list-group mb-4">
            @foreach ($subGroups as $subGroup) {{-- Переименовал переменную для ясности --}}
                <li class="list-group-item group-list-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('catalog.group', $subGroup->id) }}">
                        {{ $subGroup->name }}
                    </a>
                    {{-- Здесь будет отображаться количество товаров в подгруппе --}}
                    <span class="badge bg-primary rounded-pill">{{ $subGroup->total_products_count }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    <h3 class="mb-3">Товары в этой группе и подгруппах</h3>

    {{-- Форма для сортировки товаров в группе --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- Блок сортировки --}}
        <div>
            <label for="sort" class="form-label mb-0 me-2">Сортировка:</label>
            <div class="btn-group btn-group-responsive" role="group" aria-label="Сортировка товаров в группе">
                {{-- Название (А-Я) --}}
                <a href="{{ route('catalog.group', [
                        'group' => $currentGroup->id,
                        'sort_by' => 'name',
                        'sort_order' => 'asc',
                        'per_page' => $perPage
                    ]) }}"
                class="btn btn-outline-secondary {{ $sortBy === 'name' && $sortOrder === 'asc' ? 'active' : '' }}">
                    Название (А-Я)
                </a>
                {{-- Название (Я-А) --}}
                <a href="{{ route('catalog.group', [
                        'group' => $currentGroup->id,
                        'sort_by' => 'name',
                        'sort_order' => 'desc',
                        'per_page' => $perPage
                    ]) }}"
                class="btn btn-outline-secondary {{ $sortBy === 'name' && $sortOrder === 'desc' ? 'active' : '' }}">
                    Название (Я-А)
                </a>
                {{-- Цена по возрастанию --}}
                <a href="{{ route('catalog.group', [
                        'group' => $currentGroup->id,
                        'sort_by' => 'price',
                        'sort_order' => 'asc',
                        'per_page' => $perPage
                    ]) }}"
                class="btn btn-outline-secondary {{ $sortBy === 'price' && $sortOrder === 'asc' ? 'active' : '' }}">
                    Цена (возр.)
                </a>
                {{-- Цена по убыванию --}}
                <a href="{{ route('catalog.group', [
                        'group' => $currentGroup->id,
                        'sort_by' => 'price',
                        'sort_order' => 'desc',
                        'per_page' => $perPage
                    ]) }}"
                class="btn btn-outline-secondary {{ $sortBy === 'price' && $sortOrder === 'desc' ? 'active' : '' }}">
                    Цена (убыв.)
                </a>
            </div>
        </div>

        {{-- Блок выбора количества товаров на странице --}}
        <div>
            <label for="per_page" class="form-label mb-0 me-2">Показать:</label>
            <div class="btn-group" role="group" aria-label="Количество товаров на странице">
                @foreach([6, 12, 18] as $option)
                    <a href="{{ route('catalog.group', [
                            'group' => $currentGroup->id,
                            'sort_by' => $sortBy,
                            'sort_order' => $sortOrder,
                            'per_page' => $option
                        ]) }}"
                    class="btn btn-outline-secondary {{ $perPage == $option ? 'active' : '' }}">
                        {{ $option }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Отображение товаров --}}
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4"> {{-- 3 товара в ряд на больших экранах --}}
                <div class="card product-card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('catalog.product', $product->id) }}">
                                {{ $product->name }}
                            </a>
                        </h5>
                        {{-- Проверка наличия цены --}}
                        <p class="card-text">Цена:
                            <strong>{{ number_format($product->price->price ?? 0, 2, ',', ' ') }} руб.</strong>
                        </p>
                    </div>
                </div>
            </div>
        @empty
            {{-- Сообщение, если товаров нет --}}
            <div class="col-12">
                <p class="alert alert-info">Нет товаров в этой группе.</p>
            </div>
        @endforelse
    </div>

    {{-- Пагинация --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends([
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'per_page' => $perPage
        ])->links('pagination::bootstrap-5') }}
    </div>

@endsection