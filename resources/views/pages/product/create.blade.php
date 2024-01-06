@extends('layout.index')

@section('html')
    <div class="okved-mutation">
        <div class="container">
            <div class="okved-mutation__container">
                <form class="form okved-mutation__form" action="{{ route('product.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="receipt_id" value="{{ Request::get('receipt_id') }}">
                    <div class="form__inputs">
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Имя</span>
                                <input class="input" type="text" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Цена</span>
                                <input class="input" type="number" name="price" value="{{ old('price') }}">
                                @error('price')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Количество</span>
                                <input class="input" type="number" name="quantity"
                                    value="{{ old('quantity') }}">
                                @error('quantity')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <button class="btn">Создать</button>
                </form>
            </div>
        </div>
    </div>
@endsection
