@extends('layout.index')

@section('html')
    <div class="folder-mutation">
        <div class="container">
            <div class="folder-mutation__container">
                <form class="form folder-mutation__form" action="{{ route('folder.update', ['folder' => $folder->id]) }}"
                    method="POST">
                    @csrf
                    <div class="form__inputs">
                        <label class="label">
                            <span class="label__title">Название*</span>
                            <input class="input" type="text" name="name" value="{{ old('name') ?? $folder->name }}"
                                maxlength="255" required>
                            @error('name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                    {{ method_field('PATCH') }}
                    <button class="btn">Изменить</button>
                </form>
                <form class="form-delete" action="{{ route('folder.destroy', ['folder' => $folder->id]) }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button class="link-red">Удалить</button>
                </form>
            </div>
        </div>
    </div>
@endsection