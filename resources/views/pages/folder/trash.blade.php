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
                            <th>Имя клиента</th>
                            <th>ID клиента</th>
                            <th>Действие</th>
                            <th>Дата закрытия</th>
                        </thead>
                        @foreach ($folders as $index => $folder)
                            @if (
                                $index > 0 &&
                                    ($folders[$index - 1]['client_name'] !== $folder->client_name ||
                                        $folders[$index - 1]['client_id'] !== $folder->client_id))
                                <tr class="folder-get__client">
                                    <td class="folder-get__client_name">
                                        <div class="folder-get__client_name_text">
                                            {{ $folder->client_name }}
                                        </div>
                                    </td>
                                    <td></td>
                                    <td class="folder-get__client_name_hidden">{{ $folder->client_name }}</td>
                                </tr>
                            @endif
                            <tr class="folder-item">
                                <td>{{ $folder->id }}</td>
                                <td style="width: 100%">
                                    <a class="link"
                                        href="{{ route('folder.show', ['folder' => $folder->id]) }}">{{ $folder->name }}</a>
                                </td>
                                <td>{{ $folder->client_name ?? '-' }}</td>
                                <td>{{ $folder->client_id ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('folder.restore', ['id' => $folder->id]) }}" method="POST">
                                        @csrf
                                        {{ method_field('PATCH') }}
                                        <button class="link folder-item__link">Вернуть в работу</button>
                                    </form>
                                </td>
                                <td>{{ $folder->deleted_at }}</td>
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
