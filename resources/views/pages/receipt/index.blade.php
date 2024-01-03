@extends('layout.index')

@section('html')
    <section class="receipt-get">
        <div class="container">
            <div class="receipt-get__container">
                <div class="receipt-get__filter">
                    <details class="details receipt-get-details">
                        <summary class="receipt-get-details__switch">Позиция чека</summary>
                        <div class="receipt-get-details__content">
                            <div class="receipt-get__col"></div>
                        </div>
                    </details>
                    <details class="details receipt-get-details">
                        <summary class="receipt-get-details__switch">Дата</summary>
                        <div class="receipt-get-details__content">
                            <label class="label">
                                <span class="label__title">Покупки от</span>
                                <input class="input" type="date" name="filterGEQ[dateTime]">
                            </label>
                            <label class="label">
                                <span class="label__title">Покупки до</span>
                                <input class="input" type="date" name="filterLEQ[dateTime]">
                            </label>
                        </div>
                    </details>
                    <details class="details receipt-get-details">
                        <summary class="receipt-get-details__switch">Оргазация</summary>
                        <div class="receipt-get-details__content"></div>
                    </details>
                    <details class="details receipt-get-details">
                        <summary class="receipt-get-details__switch">Сумма по чеку</summary>
                        <div class="receipt-get-details__content"></div>
                    </details>
                    <details class="details receipt-get-details">
                        <summary class="receipt-get-details__switch">Фиксальные данные</summary>
                        <div class="receipt-get-details__content"></div>
                    </details>
                </div>
                <div class="receipt-get__content">
                </div>
            </div>
        </div>
    </section>
@endsection
