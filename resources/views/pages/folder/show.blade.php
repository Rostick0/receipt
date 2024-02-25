@extends('layout.index')

@php
    $folder_receipts_count = $folder
        ->folder_receipts()
        ->whereHas('receipt', function ($query) {
            // $query->whereNull('deleted_at');
        })
        ->count();
@endphp

@section('html')
    <section class="folder-get">
        <div class="container">
            <div class="receipt-get__container">
                <x-receipt-filter :total="$receipts->total()" />
                <div class="folder-get__container">
                    <div class="folder-get__top">
                        <div class="folder-get__info">
                            <strong>{{ $folder->name }}</strong>
                            <div class="folder-get__count">Количество чеков: {{ $folder_receipts_count }}</div>
                            <div @isset($sum_query[0]?->sum) $sum_query @endisset class="folder-get__count">
                                Сумма:
                                {{ number_format($sum_query[0]?->sum / 100, 2, '.', ' ') }} руб
                            </div>
                            @if ($receipts->total() > 0)
                                <a class="ml-auto link"
                                    href="{{ route('receipt-upload.index', [
                                        'folder_id' => $folder->id,
                                    ]) }}">Скачать
                                    все</a>
                                <form action="{{ route('folder.clear', ['id' => $folder->id]) }}" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button class="link-red" href="">Очистить все</button>
                                </form>
                            @endif
                        </div>
                        <div class="folder-get__action">
                            @if ($folder->trashed())
                                <form action="{{ route('folder.restore', ['id' => $folder->id]) }}" method="POST">
                                    @csrf
                                    {{ method_field('PATCH') }}
                                    <button class="link">Вернуть сделку в работу</button>
                                </form>
                            @else
                                <a class="btn" href="{{ route('folder.edit', ['folder' => $folder->id]) }}">Изменить</a>
                                <form action="{{ route('folder.destroy', ['folder' => $folder->id]) }}" method="POST">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button class="link">Закрыть сделку</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="folder-get__content">
                        @if ($receipts->count())
                            <div class="receipt-list">
                                @foreach ($receipts as $item)
                                    <x-receipt-item :receipt="$item" classStar="_remove" :folderReceiptId="$item->folder_receipts->where('folder_id', $folder->id)->first()->id" />
                                @endforeach
                            </div>
                            <div class="pagination-margin">
                                {{ $receipts->appends(Request::all())->links('vendor.pagination') }}
                            </div>
                        @else
                            <div class=" not-found">Ничего не найдено
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
