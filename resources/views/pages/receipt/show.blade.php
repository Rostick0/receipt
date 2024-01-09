@extends('layout.index')

@section('html')
    <section class="receipt-get">
        <div class="container">
            <div class="receipt-get__container">
                <div class="receipt-get__content">
                    <div class="receipt-get__action">
                        @can('update', $receipt)
                            <a class="btn" href="{{ route('receipt.edit', ['receipt' => $receipt->id]) }}">Изменить</a>
                        @endcan
                        <a class="link" href="{{ route('receipt-upload.show', ['receipt_upload' => $receipt->id]) }}"
                            download="{{ $receipt->user . '-' . $receipt->totalSum }}.json">Скачать</a>
                    </div>
                    <x-receipt-item :receipt="$receipt" />
                </div>
            </div>
        </div>
    </section>
@endsection
