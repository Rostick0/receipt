@extends('layout.index')

@php
    $folder_receipts = $folder->folder_receipts()->paginate(20);
@endphp

@section('html')
    <section class="folder-get">
        <div class="container">
            <div class="folder-get__container">
                <div class="folder-get__top">
                    <div class="folder-get__info">
                        <strong>{{ $folder->name }}</strong>
                        <div class="folder-get__count">Количество чеков: {{ $folder_receipts->count() }}</div>
                    </div>
                    <div class="folder-get__action">
                        <a class="btn" href="{{ route('folder.edit', ['folder' => $folder->id]) }}">Изменить</a>
                        <a class="link" href="">Скачать</a>
                    </div>
                </div>
                <div class="folder-get__content">
                    @if ($folder_receipts->count())
                        <div class="receipt-list">
                            @foreach ($folder_receipts as $item)
                                <x-receipt-item :receipt="$item->receipt" />
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
