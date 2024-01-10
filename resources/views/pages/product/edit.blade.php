@extends('layout.index')

@section('html')
    <div class="okved-mutation">
        <div class="container">
            <div class="okved-mutation__container">
                <form class="form okved-mutation__form" action="{{ route('product.update', ['product' => $product->id]) }}"
                    method="POST">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="form__inputs">
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Имя</span>
                                <input class="input" type="text" name="name"
                                    value="{{ old('name') ?? $product->name }}" maxlength="255" required>
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Цена</span>
                                <input class="input" type="number" name="price"
                                    value="{{ old('price') ?? $product->price }}" required>
                                @error('price')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Количество</span>
                                <input class="input" type="number" name="quantity"
                                    value="{{ old('quantity') ?? $product->quantity }}" required>
                                @error('quantity')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <button class="btn">Создать</button>
                </form>
                <form action="{{ route('product.destroy', ['product' => $product->id]) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button class="link link-red">Удалить</button>
                    <a class="link" href="{{ route('receipt.edit', ['receipt' => $product->receipt]) }}">Вернуться к
                        чеку</a>
                </form>
            </div>
        </div>
    </div>
@endsection
