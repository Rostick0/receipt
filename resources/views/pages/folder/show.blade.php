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
                        {{-- @dd($folder->with('folder_receipts', function ($query) {
                            $query->withSum('receipt', '');
                        })->get()) --}}
                        {{-- <pre>{{$folder->folder_receipts()->withSum('receipt', 'totalSum')->get()}}</pre> --}}
                        {{-- @dd(
                            // $folder->folder_receipts()->withSum('receipt', 'totalSum')->sum('receipt_sum_total_sum')
                            // $folder->folder_receipts()->receipt()->sum('totalSum')
                            // $folder->folder_receipts->receipt()->sum('totalSum')
                        ); --}}

                        {{-- @dd($folder->folder_receipts->receipt) --}}
                        {{-- ()->sum('totalSum') --}}
                        <strong>{{ $folder->name }}</strong>
                        <div class="folder-get__count">Количество чеков: {{ $folder_receipts->total() }}</div>
                        {{-- <div class="folder-get__amount">Общая сумма: {{ $folder_receipts->sum('totalSum') }}</div> --}}
                        <a class="ml-auto link" href="">Скачать все</a>
                        <form action="{{ route('folder.clear', ['id' => $folder->id]) }}" method="post">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button class="link-red" href="">Очистить все</button>
                        </form>
                    </div>
                    <div class="folder-get__action">
                        <a class="btn" href="{{ route('folder.edit', ['folder' => $folder->id]) }}">Изменить</a>
                    </div>
                </div>
                <div class="folder-get__content">
                    @if ($folder_receipts->count())
                        <div class="receipt-list">
                            @foreach ($folder_receipts as $item)
                            {{-- @dd($item) --}}
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
