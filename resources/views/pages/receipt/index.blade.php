@extends('layout.index')

@section('html')
<x-modal-folders />
<section class="receipt-get">
    <div class="container">
        <div class="receipt-get__container">
            <x-receipt-filter :total="$receipts->total()" />
            <div class="receipt-get__content">
                @if ($receipts->count())
                <div class="receipt-list">
                    @foreach ($receipts as $item)
                    <x-receipt-item :receipt="$item" />
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
</section>
@endsection