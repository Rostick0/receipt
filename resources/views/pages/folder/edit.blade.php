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
                        <label class="label">
                            <span class="label__title">ID клиента</span>
                            <input class="input" type="number" name="client_id"
                                value="{{ old('client_id') ?? $folder->client_id }}" maxlength="16">
                            @error('client_id')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </label>
                        <label class="label">
                            <span class="label__title">Имя клиента</span>
                            <input class="input" type="text" name="client_name"
                                value="{{ old('client_name') ?? $folder->client_name }}" maxlength="255">
                            @error('client_name')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                    {{ method_field('PATCH') }}
                    <button class="btn">Изменить</button>
                </form>
                <div class="d-flex form-delete">
                    <form action="{{ route('folder.destroy', ['folder' => $folder->id]) }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button class="link-red">Закрыть сделку</button>
                    </form>
                    <form action="{{ route('folder.forceDelete', ['id' => $folder->id]) }}" method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                        <button class="link-red">Удалить сделку</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
