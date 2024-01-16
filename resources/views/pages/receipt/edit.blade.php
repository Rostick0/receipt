@extends('layout.index')

@section('html')
    <div class="okved-mutation">
        <div class="container">
            <div class="okved-mutation__container">
                <form class="form okved-mutation__form" action="{{ route('receipt.update', ['receipt' => $receipt->id]) }}"
                    method="POST">
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="form__inputs">
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Дата покупки</span>
                                <input class="input" type="datetime-local" name="dateTime"
                                    value="{{ old('dateTime') ?? $receipt->dateTime }}">
                                @error('dateTime')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">cashTotalSum</span>
                                <input class="input" type="number" name="cashTotalSum" step="0.01"
                                    value="{{ App\Utils\PriceUtil::checkAndDivision(old('cashTotalSum') ?? $receipt->cashTotalSum) }}">
                                @error('cashTotalSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">creditSum</span>
                                <input class="input" type="number" name="creditSum" step="0.01"
                                    value="{{ App\Utils\PriceUtil::checkAndDivision(old('creditSum') ?? $receipt->creditSum) }}">
                                @error('creditSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">ecashTotalSum</span>
                                <input class="input" type="number" name="ecashTotalSum" step="0.01"
                                    value="{{ App\Utils\PriceUtil::checkAndDivision(old('ecashTotalSum') ?? $receipt->ecashTotalSum) }}">
                                @error('ecashTotalSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">code</span>
                                <input class="input" type="text" name="code" maxlength="255"
                                    value="{{ old('code') ?? $receipt->code }}">
                                @error('code')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">fiscalDocumentFormatVer</span>
                                <input class="input" type="text" name="fiscalDocumentFormatVer" maxlength="255"
                                    value="{{ old('fiscalDocumentFormatVer') ?? $receipt->fiscalDocumentFormatVer }}">
                                @error('fiscalDocumentFormatVer')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">ФД*</span>
                                <input class="input" type="text" name="fiscalDocumentNumber" maxlength="255"
                                    value="{{ old('fiscalDocumentNumber') ?? $receipt->fiscalDocumentNumber }}" required>
                                @error('fiscalDocumentNumber')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">ФН*</span>
                                <input class="input" type="text" name="fiscalDriveNumber" maxlength="255"
                                    value="{{ old('fiscalDriveNumber') ?? $receipt->fiscalDriveNumber }}" required>
                                @error('fiscalDriveNumber')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">ФПД*</span>
                                <input class="input" type="text" name="fiscalSign" maxlength="255"
                                    value="{{ old('fiscalSign') ?? $receipt->fiscalSign }}" required>
                                @error('fiscalSign')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">РЕГ.НОМЕР ККТ*</span>
                                <input class="input" type="text" name="kktRegId" maxlength="255"
                                    value="{{ old('kktRegId') ?? $receipt->kktRegId }}" required>
                                @error('kktRegId')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">НДС 0</span>
                                <input class="input" type="text" name="nds0" maxlength="8"
                                    value="{{ old('nds0') ?? $receipt->nds0 }}">
                                @error('nds0')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">БЕЗ НДС</span>
                                <input class="input" type="text" name="ndsNo" maxlength="8"
                                    value="{{ old('ndsNo') ?? $receipt->ndsNo }}">
                                @error('ndsNo')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">НДС 10</span>
                                <input class="input" type="text" name="nds10" maxlength="8"
                                    value="{{ old('nds10') ?? $receipt->nds10 }}">
                                @error('nds10')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">НДС 20</span>
                                <input class="input" type="text" name="nds20" maxlength="8"
                                    value="{{ old('nds20') ?? $receipt->nds20 }}">
                                @error('nds20')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Вид чека*</span>
                                <select class="input" name="operationType" required>
                                    <option value="" hidden></option>
                                    @foreach ($operation_types as $item)
                                        <option @if ((old('operationType') ?? $item->id) == $receipt->operationType) selected @endif
                                            value="{{ $item->id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('operationType')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Сумма предоплаты</span>
                                <input class="input" type="number" name="prepaidSum" maxlength="8" step="0.01"
                                    value="{{ App\Utils\PriceUtil::checkAndDivision(old('prepaidSum') ?? $receipt->prepaidSum) }}">
                                @error('prepaidSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Сумма резерва</span>
                                <input class="input" type="number" name="provisionSum" maxlength="8" step="0.01"
                                    value="{{ App\Utils\PriceUtil::checkAndDivision(old('provisionSum') ?? $receipt->provisionSum) }}">
                                @error('provisionSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Номер запроса</span>
                                <input class="input" type="number" name="requestNumber" maxlength="8"
                                    value="{{ old('requestNumber') ?? $receipt->requestNumber }}">
                                @error('requestNumber')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Место розничной торговли</span>
                                <input class="input" type="text" name="retailPlace" maxlength="255"
                                    value="{{ old('retailPlace') ?? $receipt->retailPlace }}">
                                @error('retailPlace')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Адрес</span>
                                <input class="input" type="text" name="retailPlaceAddress" maxlength="255"
                                    value="{{ old('retailPlaceAddress') ?? $receipt->retailPlaceAddress }}">
                                @error('retailPlaceAddress')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Номер смены</span>
                                <input class="input" type="number" name="shiftNumber" maxlength="255"
                                    value="{{ old('shiftNumber') ?? $receipt->shiftNumber }}">
                                @error('shiftNumber')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Вид налогооблажения*</span>
                                <select class="input" name="taxationType" required>
                                    <option value="" hidden></option>
                                    @foreach ($taxation_types as $item)
                                        <option @if ((old('taxationType') ?? $item->id) == $receipt->taxationType) selected @endif
                                            value="{{ $item->id }}">
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('taxationType')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Компания*</span>
                                <input class="input" type="text" name="user" maxlength="255"
                                    value="{{ old('user') ?? $receipt->user }}" required>
                                @error('user')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">ИНН*</span>
                                <input class="input" type="number" name="userInn" maxlength="255"
                                    value="{{ old('userInn') ?? $receipt->userInn }}" required>
                                @error('userInn')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <x-select-async-search data_url="/api/okved" title="ОКВЭД" placeholder="ОКВЭД" name="okved"
                            date_item_id="{{ old('okved_id') ?? $receipt->okved_id }}"
                            date_item_name="{{ old('okved_name') ?? ($receipt->okved?->name ?? '') }}"
                            name="okved_name" />
                    </div>
                    <button class="btn">Изменить</button>
                </form>
            </div>
            <form class="form-delete" action="{{ route('receipt.destroy', ['receipt' => $receipt->id]) }}" method="POST">
                @csrf
                {{ method_field('DELETE') }}
                <button class="link-red">Удалить</button>
            </form>
            <br>
            <div class="okved-mutation-products">
                <div class="okved-mutation-products__top">
                    <h2>Товары</h2>
                    <a class="btn" href="{{ route('product.create', ['receipt_id' => $receipt->id]) }}">Добавить</a>
                </div>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Количества</th>
                        <th>Сумма</th>
                        <th>Действие</th>
                    </thead>
                    <tbody>
                        @foreach ($receipt->products as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price / 100 }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->sum / 100 }}</td>
                                <td>
                                    <a class="link"
                                        href="{{ route('product.edit', ['product' => $item->id]) }}">Ред</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
