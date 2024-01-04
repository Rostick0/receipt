@extends('layout.index')

@section('html')
    <section class="okved-get">
        <div class="container">
            <div class="okved-get__container">
                <form class="okved-get__form" action="{{ url()->current() }}">
                    <input class="input" placeholder="Название ОКВЭД" type="search" name="filterLIKE[name]"
                        value="{{ Request::get('filterLIKE')['name'] ?? null }}">
                    <button class="btn">Найти</button>
                </form>
                @if ($okveds->count())
                    <table class="table okved-table">
                        <thead>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>ID Род-кого OКВЭД</th>
                            <th>Действие</th>
                        </thead>
                        @foreach ($okveds as $okved)
                            <tr class="okved-item">
                                <td>{{ $okved->id }}</td>
                                <td>{{ $okved->name }}</td>
                                <td>{{ $okved->parent?->id ?? '-' }}</td>
                                <td>
                                    <a class="link okved-item__link"
                                        href="{{ route('okved.edit', ['okved' => $okved->id]) }}">Ред</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="pagination-margin">
                        {{ $okveds->appends(Request::all())->links('vendor.pagination') }}
                    </div>
                @else
                    <div class="not-found">Ничего не найдено</div>
                @endif
            </div>
        </div>
    </section>
@endsection
