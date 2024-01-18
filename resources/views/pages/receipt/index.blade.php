@extends('layout.index')

@section('html')
    <section class="receipt-get">
        <div class="container">
            <div class="receipt-get__container">
                <form class="receipt-get__filter" action="{{ url()->current() }}">
                    <div>
                        <details class="details receipt-get-details" @if (isset(Request::get('filterLIKE')['products.name']) ||
                                isset(Request::get('filterGEQ')['products.price']) ||
                                isset(Request::get('filterLEQ')['products.price']) ||
                                isset(Request::get('filterGEQ')['products.quantity']) ||
                                isset(Request::get('filterLEQ')['products.quantity']) ||
                                isset(Request::get('filterGEQ')['products.sum']) ||
                                isset(Request::get('filterLEQ')['products.sum'])) open @endif>
                            <summary class="receipt-get-details__switch">Позиция чека</summary>
                            <div class="receipt-get-details__content">
                                <label class="label">
                                    <span class="label__title">Название товара/услуги</span>
                                    <input class="input" type="text" name="filterLIKE[products.name]"
                                        value="{{ Request::get('filterLIKE')['products.name'] ?? null }}">
                                </label>
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Цена от</span>
                                        <input class="input" type="number" name="filterGEQ[products.price]" step="0.01"
                                            @if (isset(Request::get('filterGEQ')['products.price'])) value="{{ Request::get('filterGEQ')['products.price'] / 100 }}" @endif>
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Цена до</span>
                                        <input class="input" type="number" name="filterLEQ[products.price]" step="0.01"
                                            @if (isset(Request::get('filterLEQ')['products.price'])) value="{{ Request::get('filterLEQ')['products.price'] / 100 }}" @endif>
                                    </label>
                                </div>
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Количество от</span>
                                        <input class="input" type="number" name="filterGEQ[products.quantity]"
                                            value="{{ Request::get('filterGEQ')['products.quantity'] ?? null }}">
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Количество до</span>
                                        <input class="input" type="number" name="filterLEQ[products.quantity]"
                                            value="{{ Request::get('filterLEQ')['products.quantity'] ?? null }}">
                                    </label>
                                </div>
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Сумма от</span>
                                        <input class="input" type="number" name="filterGEQ[products.sum]" step="0.01"
                                            @if (isset(Request::get('filterGEQ')['products.sum'])) value="{{ Request::get('filterGEQ')['products.sum'] / 100 }}" @endif>
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Сумма до</span>
                                        <input class="input" type="number" name="filterLEQ[products.sum]" step="0.01"
                                            @if (isset(Request::get('filterLEQ')['products.sum'])) value="{{ Request::get('filterLEQ')['products.sum'] / 100 }}" @endif>
                                    </label>
                                </div>
                            </div>
                        </details>
                        <details class="details receipt-get-details" @if (isset(Request::get('filterGEQ')['dateTime']) || isset(Request::get('filterLEQ')['dateTime'])) open @endif>
                            <summary class="receipt-get-details__switch">Дата</summary>
                            <div class="receipt-get-details__content">
                                <label class="label">
                                    <span class="label__title">Покупки от</span>
                                    <input class="input" type="date" name="filterGEQ[dateTime]"
                                        value="{{ Request::get('filterGEQ')['dateTime'] ?? null }}">
                                </label>
                                <label class="label">
                                    <span class="label__title">Покупки до</span>
                                    <input class="input" type="date" name="filterLEQ[dateTime]"
                                        value="{{ Request::get('filterLEQ')['dateTime'] ?? null }}">
                                </label>
                            </div>
                        </details>
                        <details class="details receipt-get-details" @if (isset(Request::get('filterLIKE')['user']) ||
                                isset(Request::get('filterLIKE')['userInn']) ||
                                isset(Request::get('filterLIKE')['retailPlaceAddress'])) open @endif>
                            <summary class="receipt-get-details__switch">Организация</summary>
                            <div class="receipt-get-details__content">
                                <label class="label">
                                    <span class="label__title">Название</span>
                                    <input class="input" type="text" name="filterLIKE[user]"
                                        value="{{ Request::get('filterLIKE')['user'] ?? null }}">
                                </label>
                                <label class="label">
                                    <span class="label__title">ИНН</span>
                                    <input class="input" type="number" name="filterLIKE[userInn]"
                                        value="{{ Request::get('filterLIKE')['userInn'] ?? null }}">
                                </label>
                                <label class="label">
                                    <span class="label__title">Адрес</span>
                                    <input class="input" type="text" name="filterLIKE[retailPlaceAddress]"
                                        value="{{ Request::get('filterLIKE')['retailPlaceAddress'] ?? null }}">
                                </label>
                            </div>
                        </details>
                        <details class="details receipt-get-details" @if (isset(Request::get('filterGEQ')['totalSum']) ||
                                isset(Request::get('filterLEQ')['totalSum']) ||
                                isset(Request::get('filterGEQ')['cashTotalSum']) ||
                                isset(Request::get('filterLEQ')['cashTotalSum']) ||
                                isset(Request::get('filterGEQ')['creditSum']) ||
                                isset(Request::get('filterLEQ')['creditSum'])) open @endif>
                            <summary class="receipt-get-details__switch">Сумма по чеку</summary>
                            <div class="receipt-get-details__content">
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Итого от</span>
                                        <input class="input" type="number" name="filterGEQ[totalSum]" step="0.01"
                                            @if (isset(Request::get('filterGEQ')['totalSum'])) value="{{ Request::get('filterGEQ')['totalSum'] / 100 }}" @endif>
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Итого по</span>
                                        <input class="input" type="number" name="filterLEQ[totalSum]"
                                            step="0.01"
                                            @if (isset(Request::get('filterLEQ')['totalSum'])) value="{{ Request::get('filterLEQ')['totalSum'] / 100 }}" @endif>
                                    </label>
                                </div>
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Наличные от</span>
                                        <input class="input" type="number" name="filterGEQ[cashTotalSum]"
                                            step="0.01"
                                            @if (isset(Request::get('filterGEQ')['cashTotalSum'])) value="{{ Request::get('filterGEQ')['cashTotalSum'] / 100 }}" @endif>
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Наличные по</span>
                                        <input class="input" type="number" name="filterLEQ[cashTotalSum]"
                                            step="0.01"
                                            @if (isset(Request::get('filterLEQ')['cashTotalSum'])) value="{{ Request::get('filterLEQ')['cashTotalSum'] / 100 }}" @endif>
                                    </label>
                                </div>
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Карта от</span>
                                        <input class="input" type="number" name="filterGEQ[creditSum]" step="0.01"
                                            @if (isset(Request::get('filterGEQ')['creditSum'])) value="{{ Request::get('filterGEQ')['creditSum'] / 100 }}" @endif>
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Карта по</span>
                                        <input class="input" type="number" name="filterLEQ[creditSum]" step="0.01"
                                            @if (isset(Request::get('filterLEQ')['creditSum'])) value="{{ Request::get('filterLEQ')['creditSum'] / 100 }}" @endif>
                                    </label>
                                </div>
                            </div>
                        </details>
                        <details class="details receipt-get-details" @if (isset(Request::get('filterLIKE')['fiscalDriveNumber']) ||
                                isset(Request::get('filterLIKE')['fiscalDocumentNumber']) ||
                                isset(Request::get('filterLIKE')['fiscalDocumentFormatVer']) ||
                                isset(Request::get('filterEQ')['operationType'])) open @endif>
                            <summary class="receipt-get-details__switch">Фискальные данные</summary>
                            <div class="receipt-get-details__content">
                                <label class="label">
                                    <span class="label__title">Номер фиксального накопителя</span>
                                    <input class="input" type="number" name="filterLIKE[fiscalDriveNumber]"
                                        value="{{ Request::get('filterLIKE')['fiscalDriveNumber'] ?? null }}">
                                </label>
                                <label class="label">
                                    <span class="label__title">Номер фиксального документа</span>
                                    <input class="input" type="number" name="filterLIKE[fiscalDocumentNumber]"
                                        value="{{ Request::get('filterLIKE')['fiscalDocumentNumber'] ?? null }}">
                                </label>
                                <label class="label">
                                    <span class="label__title">Фиксального признак документа</span>
                                    <input class="input" type="number" name="filterLIKE[fiscalDocumentFormatVer]"
                                        value="{{ Request::get('filterLIKE')['fiscalDocumentFormatVer'] ?? null }}">
                                </label>
                                <label class="label">
                                    <span class="label__title">Вид чека</span>
                                    <select class="input" type="number" name="filterEQ[operationType]">
                                        <option value="">Любой</option>
                                        @if (isset(Request::get('filterEQ')['operationType']))
                                            @foreach ($operation_types as $item)
                                                <option @if ($item->id == Request::get('filterEQ')['operationType']) selected @endif
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($operation_types as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </label>
                            </div>
                        </details>
                    </div>
                    <div class="receipt-get__filter_bottom">
                        <button class="btn">Применить</button>
                        <a class="link-red align-self-start" href="{{ route('receipt.index') }}">Сброс</a>
                    </div>
                </form>
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
