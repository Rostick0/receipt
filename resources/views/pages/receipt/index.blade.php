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
                                        <input class="input" type="number" name="filterGEQ[products.price]"
                                            value="{{ Request::get('filterGEQ')['products.price'] ?? null }}">
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Цена до</span>
                                        <input class="input" type="number" name="filterLEQ[products.price]"
                                            value="{{ Request::get('filterLEQ')['products.price'] ?? null }}">
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
                                        <input class="input" type="number" name="filterGEQ[products.sum]"
                                            value="{{ Request::get('filterGEQ')['products.sum'] ?? null }}">
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Сумма до</span>
                                        <input class="input" type="number" name="filterLEQ[products.sum]"
                                            value="{{ Request::get('filterLEQ')['products.sum'] ?? null }}">
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
                            <summary class="receipt-get-details__switch">Оргазация</summary>
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
                        <details class="details receipt-get-details" @if (isset(Request::get('filterGEQ')['ecashTotalSum']) ||
                                isset(Request::get('filterLEQ')['ecashTotalSum']) ||
                                isset(Request::get('filterGEQ')['cashTotalSum']) ||
                                isset(Request::get('filterLEQ')['cashTotalSum']) ||
                                isset(Request::get('filterGEQ')['creditSum']) ||
                                isset(Request::get('filterLEQ')['creditSum']))  @endif>
                            <summary class="receipt-get-details__switch">Сумма по чеку</summary>
                            <div class="receipt-get-details__content">
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Итого от</span>
                                        <input class="input" type="number" name="filterGEQ[ecashTotalSum]"
                                            value="{{ Request::get('filterGEQ')['ecashTotalSum'] ?? null }}">
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Итого по</span>
                                        <input class="input" type="number" name="filterLEQ[ecashTotalSum]"
                                            value="{{ Request::get('filterLEQ')['ecashTotalSum'] ?? null }}">
                                    </label>
                                </div>
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Наличные от</span>
                                        <input class="input" type="number" name="filterGEQ[cashTotalSum]"
                                            value="{{ Request::get('filterGEQ')['cashTotalSum'] ?? null }}">
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Наличные по</span>
                                        <input class="input" type="number" name="filterLEQ[cashTotalSum]"
                                            value="{{ Request::get('filterLEQ')['cashTotalSum'] ?? null }}">
                                    </label>
                                </div>
                                <div class="receipt-get__col">
                                    <label class="label">
                                        <span class="label__title">Карта от</span>
                                        <input class="input" type="number" name="filterGEQ[creditSum]"
                                            value="{{ Request::get('filterGEQ')['creditSum'] ?? null }}">
                                    </label>
                                    <label class="label">
                                        <span class="label__title">Карта по</span>
                                        <input class="input" type="number" name="filterLEQ[creditSum]"
                                            value="{{ Request::get('filterLEQ')['creditSum'] ?? null }}">
                                    </label>
                                </div>
                            </div>
                        </details>
                        <details class="details receipt-get-details" @if (isset(Request::get('filterLIKE')['fiscalDriveNumber']) ||
                                isset(Request::get('filterLIKE')['fiscalDocumentNumber']) ||
                                isset(Request::get('filterLIKE')['fiscalDocumentFormatVer']) ||
                                isset(Request::get('filterEQ')['operationType'])) open @endif>
                            <summary class="receipt-get-details__switch">Фиксальные данные</summary>
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
                    <ul class="receipt-list">
                        @foreach ($receipts as $item)
                            <li class="receipt-item">
                                <div class="receipt-item__top">
                                    <div class="receipt-tiem__id">Чек № {{ $item->id }}</div>
                                    <button class="link receipt-item__more">
                                        <span class="receipt-item__more_active">Подробнее</span>
                                        <span class="receipt-item__more_hidden">Скрыть</span>
                                    </button>
                                </div>
                                <div class="receipt-item__short-info">
                                    <div class="receipt-item__center">{{ $item->user }}</div>
                                    <div class="receipt-item__bottom">
                                        <div class="receipt-item__date">
                                            {{ Carbon\Carbon::parse($item->dateTime)->translatedFormat('d.m.Y H:i:s') }}
                                        </div>
                                        <div class="receipt-item__amount">
                                            <strong>Итого:</strong>
                                            <div>{{ $item->totalSum / 100 }} руб.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="receipt-item-info">
                                    <div class="text-center">{{ $item->user }}</div>
                                    <div class="text-center">{{ $item->retailPlaceAddress }}</div>
                                    <div class="text-center">{{ $item->userInn }}</div>
                                    <br>
                                    <div class="text-center">
                                        {{ Carbon\Carbon::parse($item->dateTime)->translatedFormat('d.m.Y H:i:s') }}</div>
                                    <div class="text-center">{{ $item->operationTypeCollection?->name ?? '-' }}</div>
                                    <table class="table receipt-item-info__table">
                                        <thead>
                                            <tr class="receipt-item-info__tr">
                                                <th>№</th>
                                                <th>Название</th>
                                                <th>Цена</th>
                                                <th>Кол.</th>
                                                <th>Сумма</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->products as $product)
                                                <tr class="receipt-item-info__tr">
                                                    <td>{{ $product->id }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->price / 100 }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>{{ $product->sum / 100 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="receipt-item-info__total">
                                        <div class="d-flex justify-content-between">
                                            <strong>Итого:</strong>
                                            <div>{{ $item->totalSum / 100 }}</div>
                                        </div>
                                        @if ($item->cashTotalSum)
                                            <div class="d-flex justify-content-between">
                                                <div>Наличные:</div>
                                                <div>{{ $item->cashTotalSum / 100 }}</div>
                                            </div>
                                        @endif
                                        @if ($item->creditSum || $item->ecashTotalSum)
                                            <div class="d-flex justify-content-between">
                                                <div>Карта</div>
                                                <div>{{ ($item->creditSum + $item->ecashTotalSum) / 100 }}</div>
                                            </div>
                                        @endif
                                        @if ($item->nds0)
                                            <div class="d-flex justify-content-between">
                                                <div>НДС 0%:</div>
                                                <div>{{ $item->nds0 }}</div>
                                            </div>
                                        @endif
                                        @if ($item->nds10)
                                            <div class="d-flex justify-content-between">
                                                <div>НДС 10%:</div>
                                                <div>{{ $item->nds10 }}</div>
                                            </div>
                                        @endif
                                        @if ($item->nds20)
                                            <div class="d-flex justify-content-between">
                                                <div>НДС 18%:</div>
                                                <div>{{ $item->nds20 }}</div>
                                            </div>
                                        @endif
                                        @if ($item->ndsNo)
                                            <div class="d-flex justify-content-between">
                                                <div>НДС не облагается:</div>
                                                <div>{{ $item->ndsNo }}</div>
                                            </div>
                                        @endif
                                        <div class="d-flex justify-content-between">
                                            <div>Вид налогооблажения</div>
                                            <div>{{ $item->taxationTypeCollection?->name ?? '-' }}</div>
                                        </div>
                                        <div class="receipt-item-info__hr"></div>
                                        {{-- @dd($item) --}}
                                        <div class="d-flex">
                                            <div>РЕГ. НОМЕР ККТ:&ensp;</div>
                                            <div>{{ $item->kktRegId }} </div>
                                        </div>
                                        <div class="d-flex">
                                            <div>ФН:&ensp;</div>
                                            <div>{{ $item->fiscalDriveNumber }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div>ФД:&ensp;</div>
                                            <div>{{ $item->fiscalDocumentNumber }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div>ФПД:&ensp;</div>
                                            <div>{{ $item->fiscalSign }}</div>
                                        </div>
                                        <div class="d-flex">
                                            <div>ОКВЭД:&ensp;</div>
                                            <div>{{ $item->okved->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="pagination-margin">
                        {{ $receipts->appends(Request::all())->links('vendor.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
