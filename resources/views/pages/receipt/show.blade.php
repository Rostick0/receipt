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
                    @props(['receipt'])

                    <div class="receipt-item _active">
                        <div class="receipt-item__top">
                            <span class="receipt-item__id">Чек № {{ $receipt->id }}</span>
                        </div>
                        <div class="receipt-item-info">
                            <div class="text-center">{{ $receipt->user }}</div>
                            <div class="text-center">{{ $receipt->retailPlaceAddress }}</div>
                            <div class="text-center">{{ $receipt->userInn }}</div>
                            <br>
                            <div class="text-center">
                                {{ Carbon\Carbon::parse($receipt->dateTime)->translatedFormat('d.m.Y H:i:s') }}</div>
                            <div class="text-center">{{ $receipt->operationTypeCollection?->name ?? '-' }}</div>
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
                                    @foreach ($receipt->products as $product)
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
                                    <div>{{ $receipt->totalSum / 100 }}</div>
                                </div>
                                @if ($receipt->cashTotalSum)
                                    <div class="d-flex justify-content-between">
                                        <div>Наличные:</div>
                                        <div>{{ $receipt->cashTotalSum / 100 }}</div>
                                    </div>
                                @endif
                                @if ($receipt->creditSum || $receipt->ecashTotalSum)
                                    <div class="d-flex justify-content-between">
                                        <div>Карта</div>
                                        <div>{{ ($receipt->creditSum + $receipt->ecashTotalSum) / 100 }}</div>
                                    </div>
                                @endif
                                @if ($receipt->nds0)
                                    <div class="d-flex justify-content-between">
                                        <div>НДС 0%:</div>
                                        <div>{{ $receipt->nds0 }}</div>
                                    </div>
                                @endif
                                @if ($receipt->nds10)
                                    <div class="d-flex justify-content-between">
                                        <div>НДС 10%:</div>
                                        <div>{{ $receipt->nds10 }}</div>
                                    </div>
                                @endif
                                @if ($receipt->nds18)
                                    <div class="d-flex justify-content-between">
                                        <div>НДС 18%:</div>
                                        <div>{{ $receipt->nds18 }}</div>
                                    </div>
                                @endif
                                @if ($receipt->ndsNo)
                                    <div class="d-flex justify-content-between">
                                        <div>НДС не облагается:</div>
                                        <div>{{ $receipt->ndsNo }}</div>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between">
                                    <div>Вид налогооблажения</div>
                                    <div>{{ $receipt->taxationTypeCollection?->name ?? '-' }}</div>
                                </div>
                                <div class="receipt-item-info__hr"></div>
                                <div class="d-flex">
                                    <div>РЕГ. НОМЕР ККТ:&ensp;</div>
                                    <div>{{ $receipt->kktRegId }} </div>
                                </div>
                                <div class="d-flex">
                                    <div>ФН:&ensp;</div>
                                    <div>{{ $receipt->fiscalDriveNumber }}</div>
                                </div>
                                <div class="d-flex">
                                    <div>ФД:&ensp;</div>
                                    <div>{{ $receipt->fiscalDocumentNumber }}</div>
                                </div>
                                <div class="d-flex">
                                    <div>ФПД:&ensp;</div>
                                    <div>{{ $receipt->fiscalSign }}</div>
                                </div>
                                @if (isset($receipt?->okved?->name))
                                    <div class="d-flex">
                                        <div>ОКВЭД:&ensp;</div>
                                        <div>{{ $receipt?->okved->name }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
