@extends('layout.index')

@section('html')
    <section class="folder-get">
        <div class="container">
            <div class="receipt-get__container">
                <x-receipt-filter :total="$receipts->total()" />
                <div class="folder-get__container">
                    <div class="folder-get__top">
                        <div class="folder-get__info">
                            <strong>{{ $folder->name }}</strong>
                            <div class="folder-get__count">Количество чеков: {{ $receipts->total() }}</div>
                            <div @isset($sum_query) $sum_query @endisset class="folder-get__count">
                                Сумма:
                                {{ number_format($sum_query / 100, 2, '.', ' ') }} руб
                            </div>
                            @if ($receipts->total() > 0)
                                <a class="ml-auto link"
                                    href="{{ route('api.receipt-upload.index', [
                                        'folder_id' => $folder->id,
                                    ]) }}">
                                    Скачать все
                                </a>
                                <form action="{{ route('folder.clear', ['id' => $folder->id]) }}" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button class="link-red" href="">Очистить все</button>
                                </form>
                            @endif
                        </div>
                        <div class="folder-get__action">
                            @can('update', $folder)
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
                            @endcan
                        </div>
                    </div>
                    <div class="folder-get__content">
                        @if ($receipts->count())
                            <div class="receipt-list">
                                @foreach ($receipts as $item)
                                    @php
                                        $folder_receipt = $item
                                            ->folder_receipts()
                                            ->where('folder_id', $folder->id)
                                            ->first();
                                        // dd($item->folder_receipts);
                                    @endphp
                                    @if ($folder_receipt?->id)
                                        <x-receipt-item :receipt="$item" classStar="_remove" :folderReceiptId="$folder_receipt?->id"
                                            :comment="$folder_receipt?->comment ?? ''" />
                                    @endif
                                @endforeach
                            </div>
                            <div class="pagination-margin">
                                {{ $receipts->appends(Request::all())->links('vendor.pagination') }}
                            </div>
                        @else
                            <div class="not-found">Ничего не найдено</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
