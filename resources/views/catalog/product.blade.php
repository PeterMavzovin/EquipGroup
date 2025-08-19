@extends('layouts.app')

@section('content')
    {{-- Хлебные крошки --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumbs">
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Главная</a></li>
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($loop->last)
                    {{-- Последний элемент в хлебных крошках (текущий товар) --}}
                    <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                @else
                    {{-- Промежуточные элементы хлебных крошек (группы) --}}
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                @endif
            @endforeach
        </ol>
    </nav>

    <h1 class="mb-4">{{ $product->name }}</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Информация о товаре</h5>
            <p class="card-text"><strong>Название:</strong> {{ $product->name }}</p>
            <p class="card-text"><strong>Цена:</strong>
                @if ($product->price)
                    <strong>{{ number_format($product->price->price, 2, ',', ' ') }} руб.</strong>
                @else
                    Цена не указана
                @endif
            </p>
            @if ($product->group)
                <p class="card-text"><strong>Группа:</strong> <a href="{{ route('catalog.group', $product->group->id) }}">{{ $product->group->name }}</a></p>
            @endif
        </div>
    </div>

    {{-- Кнопка "Назад" --}}
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">Назад</a>
@endsection