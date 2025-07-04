@props(['total', 'sort', 'taxation_types', 'operation_types'])

@php
    $sort = (new App\Http\Controllers\ReceiptController())->sort;
    $taxation_types = App\Models\TaxationType::get();
    $operation_types = App\Models\OperationType::get();
    $users = App\Models\User::where('is_confirmed', 1)->get();

    $filterProductName = Request::has('exact_title') ? 'filterEQ' : 'filterLIKE';
@endphp

<div class="receipt-get__left">
    <div class="receipt-get__count">Найдено чеков: {{ $total }}</div>
    <form class="receipt-get__filter" action="{{ url()->current() }}">
        <select class="input" name="sort">
            <option value="id" hidden>Сортировка</option>
            <option value="id">-</option>
            @foreach ($sort as $item)
                <option value="{{ $item['value'] }}">{{ $item['name'] }}</option>
            @endforeach
        </select>
        <div>
            <details class="details receipt-get-details" @empty(Request::get('receipt-position')) open @endempty>
                <summary class="receipt-get-details__switch">Позиция чека</summary>
                <input class="checkbox__summary" type="checkbox" name="receipt-position" @checked(!empty(Request::get('receipt-position')))
                    hidden>
                <div class="receipt-get-details__content">
                    <label class="label">
                        <span class="label__title">Название товара/услуги</span>
                        <input class="input input-product__disable" type="text"
                            name="{{ $filterProductName . '[products.name]' }}"
                            value="{{ Request::get($filterProductName)['products.name'] ?? '' }}"
                            @disabled(isset(Request::get('filterEQN')['products.name']))>
                    </label>
                    <label class="checbox">
                        <input class="checbox__input" name="exact_title" id="exact_title" @checked(Request::get('exact_title'))
                            type="checkbox">
                        <span class="checbox__icon"></span>
                        <span class="label__title">Точное название</span>
                    </label>
                    <label class="checbox">
                        <input class="checbox__input checkbox-prodict__disable" name="filterEQN[products.name]"
                            @checked(isset(Request::get('filterEQN')['products.name'])) type="checkbox">
                        <span class="checbox__icon"></span>
                        <span class="label__title">Название товара или услуги пустое</span>
                    </label>
                    <div class="receipt-get__col">
                        <label class="label">
                            <span class="label__title">Цена от</span>
                            <input class="input" type="number" name="filterGEQ[products.price]" step="0.01"
                                @if (isset(Request::get('filterGEQ')['products.price'])) value="{{ Request::get('filterGEQ')['products.price'] }}" @endif>
                        </label>
                        <label class="label">
                            <span class="label__title">Цена до</span>
                            <input class="input" type="number" name="filterLEQ[products.price]" step="0.01"
                                @if (isset(Request::get('filterLEQ')['products.price'])) value="{{ Request::get('filterLEQ')['products.price'] }}" @endif>
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
                                @if (isset(Request::get('filterGEQ')['products.sum'])) value="{{ Request::get('filterGEQ')['products.sum'] }}" @endif>
                        </label>
                        <label class="label">
                            <span class="label__title">Сумма до</span>
                            <input class="input" type="number" name="filterLEQ[products.sum]" step="0.01"
                                @if (isset(Request::get('filterLEQ')['products.sum'])) value="{{ Request::get('filterLEQ')['products.sum'] }}" @endif>
                        </label>
                    </div>
                </div>
            </details>
            <details class="details receipt-get-details" @empty(Request::get('receipt-data')) open @endempty>
                <summary class="receipt-get-details__switch">
                    Дата
                </summary>
                <input class="checkbox__summary" type="checkbox" name="receipt-data" @checked(!empty(Request::get('receipt-data')))
                    hidden>
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
            <details class="details receipt-get-details" @empty(Request::get('receipt-organization')) open @endempty>
                <summary class="receipt-get-details__switch">Организация</summary>
                <input class="checkbox__summary" type="checkbox" name="receipt-organization"
                    @checked(!empty(Request::get('receipt-organization'))) hidden>
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
                    <div class="label">
                        <div class="label__title">Вид налогооблажени</div>
                        <div class="checkbox-multi">
                            <input class="checkbox-multi__hidden" name="filterIN[taxationType]" type="hidden">
                            @foreach ($taxation_types as $item)
                                <label class="checbox">
                                    <input class="checbox__input" value="{{ $item->id }}"
                                        @checked(array_search($item->id, explode(',', Request::get('filterIN')['taxationType'] ?? '')) !== false) type="checkbox">
                                    <span class="checbox__icon"></span>
                                    <span class="label__title">{{ $item->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </details>
            <details class="details receipt-get-details" @empty(Request::get('receipt-total')) open @endempty>
                <summary class="receipt-get-details__switch">Сумма по чеку</summary>
                <input class="checkbox__summary" type="checkbox" name="receipt-total" @checked(!empty(Request::get('receipt-total')))
                    hidden>
                <div class="receipt-get-details__content">
                    <div class="receipt-get__col">
                        <label class="label">
                            <span class="label__title">Итого от</span>
                            <input class="input" type="number" name="filterGEQ[totalSum]" step="0.01"
                                @if (isset(Request::get('filterGEQ')['totalSum'])) value="{{ Request::get('filterGEQ')['totalSum'] }}" @endif>
                        </label>
                        <label class="label">
                            <span class="label__title">Итого по</span>
                            <input class="input" type="number" name="filterLEQ[totalSum]" step="0.01"
                                @if (isset(Request::get('filterLEQ')['totalSum'])) value="{{ Request::get('filterLEQ')['totalSum'] }}" @endif>
                        </label>
                    </div>
                    <div class="receipt-get__col">
                        <label class="label">
                            <span class="label__title">Наличные от</span>
                            <input class="input" type="number" name="filterGEQ[cashTotalSum]" step="0.01"
                                @if (isset(Request::get('filterGEQ')['cashTotalSum'])) value="{{ Request::get('filterGEQ')['cashTotalSum'] }}" @endif>
                        </label>
                        <label class="label">
                            <span class="label__title">Наличные по</span>
                            <input class="input" type="number" name="filterLEQ[cashTotalSum]" step="0.01"
                                @if (isset(Request::get('filterLEQ')['cashTotalSum'])) value="{{ Request::get('filterLEQ')['cashTotalSum'] }}" @endif>
                        </label>
                    </div>
                    <div class="receipt-get__col">
                        <label class="label">
                            <span class="label__title">Карта от</span>
                            <input class="input" type="number" name="filterGEQ[creditSum]" step="0.01"
                                @if (isset(Request::get('filterGEQ')['creditSum'])) value="{{ Request::get('filterGEQ')['creditSum'] }}" @endif>
                        </label>
                        <label class="label">
                            <span class="label__title">Карта по</span>
                            <input class="input" type="number" name="filterLEQ[creditSum]" step="0.01"
                                @if (isset(Request::get('filterLEQ')['creditSum'])) value="{{ Request::get('filterLEQ')['creditSum'] }}" @endif>
                        </label>
                    </div>
                    <label class="checbox">
                        <input class="checbox__input" name="nds_only" @checked(Request::get('nds_only')) type="checkbox">
                        <span class="checbox__icon"></span>
                        <span class="label__title">Только с НДС</span>
                    </label>
                    <label class="checbox">
                        <input class="checbox__input" name="no_nds_only" @checked(Request::get('no_nds_only'))
                            type="checkbox">
                        <span class="checbox__icon"></span>
                        <span class="label__title">Без НДС</span>
                    </label>
                </div>
            </details>
            <details class="details receipt-get-details" @empty(Request::get('receipt-fiscal')) open @endempty>
                <summary class="receipt-get-details__switch">Фискальные данные</summary>
                <input class="checkbox__summary" type="checkbox" name="receipt-fiscal" @checked(!empty(Request::get('receipt-fiscal')))
                    hidden>
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
                                    <option @selected($item->id == Request::get('filterEQ')['operationType']) value="{{ $item->id }}">
                                        {{ $item->name }}</option>
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
            <details class="details receipt-get-details" @empty(Request::get('receipt-user')) open @endempty>
                <summary class="receipt-get-details__switch">Пользователь</summary>
                <input class="checkbox__summary" type="checkbox" name="receipt-user" @checked(!empty(Request::get('receipt-user')))
                    hidden>
                <div class="receipt-get-details__content">
                    <div class="label">
                        <div class="label__title">Пользователь</div>
                        <div class="checkbox-multi">
                            <input class="checkbox-multi__hidden" name="filterIN[user_id]" type="hidden">
                            @foreach ($users as $item)
                                <label class="checbox">
                                    <input class="checbox__input" value="{{ $item->id }}"
                                        @checked(array_search($item->id, explode(',', Request::get('filterIN')['user_id'] ?? '')) !== false) type="checkbox">
                                    <span class="checbox__icon"></span>
                                    <span class="label__title">{{ $item->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </details>
        </div>
        <div class="receipt-get__filter_bottom">
            <button class="btn">Применить</button>
            <a class="link-red align-self-start" href="{{ url()->current() }}">Сброс</a>
        </div>
    </form>
</div>
