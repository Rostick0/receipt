@extends('layout.index')

@section('html')
    <x-modal-folders />
    <section class="receipt-get">
        <div class="container">
            <div class="receipt-get__container">
                <div class="receipt-get__left">
                    <div class="receipt-get__count">Найдено чеков: {{ $receipts->total() }}</div>
                    <form class="receipt-get__filter" action="{{ url()->current() }}">
                        <div>
                            <details class="details receipt-get-details" @empty (Request::get('receipt-position')) open @endempty>
                                <summary class="receipt-get-details__switch">Позиция чека</summary>
                                <input class="checkbox__summary" type="checkbox" name="receipt-position" @if (!empty(Request::get('receipt-position'))) checked @endif hidden>
                                <div class="receipt-get-details__content">
                                    <label class="label">
                                        <span class="label__title">Название товара/услуги</span>
                                        <input class="input input-product__disable" type="text" name="filterLIKE[products.name]"
                                            value="{{ Request::get('filterLIKE')['products.name'] ?? null }}">
                                    </label>
                                    <label class="checbox">
                                        <input class="checbox__input checkbox-prodict__disable" name="null_title" @checked(Request::get('null_title')) type="checkbox">
                                        <span class="checbox__icon"></span>
                                        <span class="label__title">Название товара или услуги пустое</span>
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
                            <details class="details receipt-get-details" @empty (Request::get('receipt-data')) open @endempty>
                                <summary class="receipt-get-details__switch">
                                    Дата
                                </summary>
                                <input class="checkbox__summary" type="checkbox" name="receipt-data" @if (!empty(Request::get('receipt-data'))) checked @endif hidden>
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
                            <details class="details receipt-get-details" @empty (Request::get('receipt-organization')) open @endempty>
                                <summary class="receipt-get-details__switch">Организация</summary>
                                <input class="checkbox__summary" type="checkbox" name="receipt-organization" @if (!empty(Request::get('receipt-organization'))) checked @endif hidden>
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
                            <details class="details receipt-get-details" @empty (Request::get('receipt-total')) open @endempty>
                                <summary class="receipt-get-details__switch">Сумма по чеку</summary>
                                <input class="checkbox__summary" type="checkbox" name="receipt-total" @if (!empty(Request::get('receipt-total'))) checked @endif hidden>
                                <div class="receipt-get-details__content">
                                    <div class="receipt-get__col">
                                        <label class="label">
                                            <span class="label__title">Итого от</span>
                                            <input class="input" type="number" name="filterGEQ[totalSum]" step="0.01"
                                                @if (isset(Request::get('filterGEQ')['totalSum'])) value="{{ Request::get('filterGEQ')['totalSum'] / 100 }}" @endif>
                                        </label>
                                        <label class="label">
                                            <span class="label__title">Итого по</span>
                                            <input class="input" type="number" name="filterLEQ[totalSum]" step="0.01"
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
                                    <label class="checbox">
                                        <input class="checbox__input" name="nds_only" @checked(Request::get('nds_only')) type="checkbox">
                                        <span class="checbox__icon"></span>
                                        <span class="label__title">Только с НДС</span>
                                    </label>
                                </div>
                            </details>
                            <details class="details receipt-get-details" @empty (Request::get('receipt-fiscal')) open @endempty>
                                <summary class="receipt-get-details__switch">Фискальные данные</summary>
                                <input class="checkbox__summary" type="checkbox" name="receipt-fiscal" @if (!empty(Request::get('receipt-fiscal'))) checked @endif hidden>
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
                </div>
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
