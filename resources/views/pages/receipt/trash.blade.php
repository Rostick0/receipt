@extends('layout.index')

@section('html')
    <section class="receipt-get">
        <div class="container">
            <div class="receipt-get__container">
                <div class="receipt-get__content">
                    @if ($receipts->count())
                        <div class="receipt-list">
                            @foreach ($receipts as $item)
                                <x-receipt-item :receipt="$item">
                                    <x-slot:action>
                                        <form action="{{ route('receipt.restore', ['id' => $item->id]) }}" method="POST">
                                            @csrf
                                            {{ method_field('PATCH') }}
                                            <button class="link-green">Восстановить</button>
                                        </form>
                                        <form action="{{ route('receipt.forceDelete', ['id' => $item->id]) }}" method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button class="link-red">Удалить</button>
                                        </form>
                                    </x-slot:action>
                                </x-receipt-item>
                            @endforeach
                        </div>
                        <div class="pagination-margin">
                            {{ $receipts->appends(Request::all())->links('vendor.pagination') }}
                        </div>
                    @else
                        <div class="not-found">Корзина пуста</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
