@extends('layout.index')

@section('html')
    <div class="folder-mutation">
        <div class="container">
            <div class="folder-mutation__container">
                <form class="form folder-mutation__form" action="{{ route('folder.store') }}" method="POST">
                    @csrf
                    <div class="form__inputs">
                        <label class="label">
                            <span class="label__title">Название*</span>
                            <input class="input" type="text" name="name" value="{{ old('name') }}" maxlength="255"
                                required>
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                    <button class="btn">Создать</button>
                </form>
            </div>
        </div>
    </div>
@endsection
