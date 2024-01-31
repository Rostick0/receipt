@extends('layout.index')

@php
    $folder_receipts = $folder
        ->folder_receipts()
        ->whereHas('receipt', function ($query) {
            $query->whereNull('deleted_at');
        })
        ->paginate(20);
@endphp

@section('html')
    <section class="folder-get">
        <div class="container">
            <div class="folder-get__container">
                <div class="folder-get__top">
                    <div class="folder-get__info">
                        <strong>{{ $folder->name }}</strong>
                        <div class="folder-get__count">Количество чеков: {{ $folder_receipts->total() }}</div>
                        {{-- {{dd($sum_query[0]->sum)}} --}}
                        <div @isset($sum_query[0]?->sum) $sum_query @endisset class="folder-get__count">Сумма:
                            {{ number_format($sum_query[0]?->sum / 100, 2, '.', ' ') }} руб </div>
                        {{-- <a class="ml-auto link" href="{{ route('receipt-upload.index', [
                            'folder_id' => $folder->id
                        ]) }}" download="{{$folder->name}}-{{$sum_query[0]?->sum ?? 0}}">Скачать все</a> --}}
                        @if ($folder_receipts->total() > 0)
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
                        <a class="btn" href="{{ route('folder.edit', ['folder' => $folder->id]) }}">Изменить</a>
                    </div>
                </div>
                <div class="folder-get__content">
                    @if ($folder_receipts->count())
                        <div class="receipt-list">
                            @foreach ($folder_receipts as $item)
                                <x-receipt-item :receipt="$item->receipt" classStar="_remove" :folderReceiptId="$item->id" />
                            @endforeach
                        </div>
                        <div class="pagination-margin">
                            {{ $folder_receipts->appends(Request::all())->links('vendor.pagination') }}
                        </div>
                    @else
                        <div class="not-found">Ничего не найдено</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
