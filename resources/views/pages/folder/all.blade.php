@extends('layout.index')

@section('html')
    <section class="folder-get">
        <div class="container">
            <div class="folder-get__container">
                <form class="folder-get__form form-get" action="{{ url()->current() }}">
                    <input class="input" placeholder="Название папки" type="search" name="filterLIKE[name]"
                        value="{{ Request::get('filterLIKE')['name'] ?? null }}">
                    <button class="btn">Найти</button>
                </form>
                @if ($folders->count())
                    <table class="table folder-table">
                        <thead>
                            <th>ID</th>
                            <th>Имя папки</th>
                            <th>Пользователь</th>
                        </thead>
                        @foreach ($folders as $index => $folder)
                            @if (
                                $index === 0 ||
                                    ($folders[$index - 1]['client_name'] !== $folder->client_name ||
                                        $folders[$index - 1]['client_id'] !== $folder->client_id))
                                <tr class="folder-get__client">
                                    <td class="folder-get__client_name">
                                        @if (isset($folder->client_name))
                                            <strong class="folder-get__client_name_text">
                                                {{ $folder->client_name }}
                                            </strong>
                                        @else
                                            <div class="folder-get__client_name_text">Без имени клиента</div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            <tr class="folder-item">
                                <td>{{ $folder->id }}</td>
                                <td style="width: 100%">
                                    <a class="link"
                                        href="{{ route('folder.show', ['folder' => $folder->id]) }}">{{ $folder->name }}</a>
                                </td>
                                <td>{{ $folder?->user?->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="pagination-margin">
                        {{ $folders->appends(Request::all())->links('vendor.pagination') }}
                    </div>
                @else
                    <div class="not-found">Ничего не найдено</div>
                @endif
            </div>
        </div>
    </section>
@endsection
