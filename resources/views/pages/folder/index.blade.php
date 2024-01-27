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
                            <th>Имя</th>
                            <th>Действие</th>
                        </thead>
                        @foreach ($folders as $folder)
                            <tr class="folder-item">
                                <td>{{ $folder->id }}</td>
                                <td style="width: 100%">{{ $folder->name }}</td>
                                <td>
                                    <a class="link folder-item__link"
                                        href="{{ route('folder.edit', ['folder' => $folder->id]) }}">Ред</a>
                                </td>
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
