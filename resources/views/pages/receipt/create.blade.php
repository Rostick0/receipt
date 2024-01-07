@extends('layout.index')

@section('html')
    <div class="okved-mutation">
        <div class="container">
            <div class="okved-mutation__container">
                <form class="form okved-mutation__form" action="{{ route('receipt.store') }}" method="POST">
                    @csrf
                    <div class="form__inputs">
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Дата покупки</span>
                                <input class="input" type="datetime-local" name="dateTime" value="{{ old('dateTime') }}">
                                @error('dateTime')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">cashTotalSum</span>
                                <input class="input" type="number" name="cashTotalSum" pattern="0.01"
                                    value="{{ old('cashTotalSum') }}">
                                @error('cashTotalSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">creditSum</span>
                                <input class="input" type="number" name="creditSum" pattern="0.01"
                                    value="{{ old('creditSum') }}">
                                @error('creditSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">ecashTotalSum</span>
                                <input class="input" type="number" name="ecashTotalSum" pattern="0.01"
                                    value="{{ old('ecashTotalSum') }}">
                                @error('ecashTotalSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">code</span>
                                <input class="input" type="text" name="code" maxlength="255"
                                    value="{{ old('code') }}">
                                @error('code')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">fiscalDocumentFormatVer</span>
                                <input class="input" type="text" name="fiscalDocumentFormatVer" maxlength="255"
                                    value="{{ old('fiscalDocumentFormatVer') }}">
                                @error('fiscalDocumentFormatVer')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">ФД*</span>
                                <input class="input" type="text" name="fiscalDocumentNumber" maxlength="255"
                                    value="{{ old('fiscalDocumentNumber') }}" required>
                                @error('fiscalDocumentNumber')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">ФН*</span>
                                <input class="input" type="text" name="fiscalDriveNumber" maxlength="255"
                                    value="{{ old('fiscalDriveNumber') }}" required>
                                @error('fiscalDriveNumber')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">ФПД*</span>
                                <input class="input" type="text" name="fiscalSign" maxlength="255"
                                    value="{{ old('fiscalSign') }}" required>
                                @error('fiscalSign')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">РЕГ.НОМЕР ККТ*</span>
                                <input class="input" type="text" name="kktRegId" maxlength="255"
                                    value="{{ old('kktRegId') }}" required>
                                @error('kktRegId')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">НДС 0</span>
                                <input class="input" type="text" name="nds0" maxlength="8"
                                    value="{{ old('nds0') }}">
                                @error('nds0')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">БЕЗ НДС</span>
                                <input class="input" type="text" name="ndsNo" maxlength="8"
                                    value="{{ old('ndsNo') }}">
                                @error('ndsNo')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">НДС 10</span>
                                <input class="input" type="text" name="nds10" maxlength="8"
                                    value="{{ old('nds10') }}">
                                @error('nds10')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">НДС 20</span>
                                <input class="input" type="text" name="nds20" maxlength="8"
                                    value="{{ old('nds20') }}">
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
                                        <option @if (old('operationType') == $item->id) selected @endif
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
                                <input class="input" type="number" name="prepaidSum" maxlength="8"
                                    value="{{ old('prepaidSum') }}">
                                @error('prepaidSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Сумма резерва</span>
                                <input class="input" type="number" name="provisionSum" maxlength="8"
                                    value="{{ old('provisionSum') }}">
                                @error('provisionSum')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Номер запроса</span>
                                <input class="input" type="number" name="requestNumber" maxlength="8"
                                    value="{{ old('requestNumber') }}">
                                @error('requestNumber')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Место розничной торговли</span>
                                <input class="input" type="text" name="retailPlace" maxlength="255"
                                    value="{{ old('retailPlace') }}">
                                @error('retailPlace')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Адрес</span>
                                <input class="input" type="text" name="retailPlaceAddress" maxlength="255"
                                    value="{{ old('retailPlaceAddress') }}">
                                @error('retailPlaceAddress')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <div class="form__col-2">
                            <label class="label">
                                <span class="label__title">Номер смены</span>
                                <input class="input" type="number" name="shiftNumber" maxlength="255"
                                    value="{{ old('shiftNumber') }}">
                                @error('shiftNumber')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">Вид налогооблажения*</span>
                                <select class="input" name="taxationType" required>
                                    <option value="" hidden></option>
                                    @foreach ($taxation_types as $item)
                                        <option @if (old('taxationType') == $item->id) selected @endif
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
                                    value="{{ old('user') }}" required>
                                @error('user')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label">
                                <span class="label__title">ИНН*</span>
                                <input class="input" type="number" name="userInn" maxlength="255"
                                    value="{{ old('userInn') }}" required>
                                @error('userInn')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                        <x-select-async-search data_url="/api/okved" title="ОКВЭД" placeholder="ОКВЭД" />
                    </div>
                    <button class="btn">Создать</button>
                </form>
            </div>
        </div>
    </div>
@endsection
