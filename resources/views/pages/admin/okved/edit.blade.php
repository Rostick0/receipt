@extends('layout.index')

@section('html')
    <div class="okved-mutation">
        <div class="container">
            <div class="okved-mutation__container">
                <form class="form okved-mutation__form" action="{{ route('okved.update', ['okved' => $okved->id]) }}"
                    method="POST">
                    @csrf
                    <div class="form__inputs">
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Название*</span>
                                <input class="input" type="text" name="name"
                                    value="{{ old('name') ?? $okved->name }}" maxlength="255" required>
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">ID родителя</span>
                                <input class="input" type="number" name="parent_id"
                                    value="{{ old('parent_id') ?? $okved->parent_id }}">
                                @error('parent_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    {{ method_field('PATCH') }}
                    <button class="btn">Изменить</button>
                </form>
                <form class="form-delete" action="{{ route('okved.destroy', ['okved' => $okved->id]) }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button class="link-red">Удалить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
