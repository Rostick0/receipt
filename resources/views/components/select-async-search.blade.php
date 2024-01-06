@props(['data_url', 'date_item_name', 'data_item_id', 'title', 'placeholder'])

<div class="select-async-search" data-url="{{ $data_url }}" data-item-id="{{ $data_item_id ?? '' }}">
    <div class="select-async-search__switch">
        @isset($title)
            <div class="select-async-search__title">{{ $title }}</div>
        @endisset
        <input class="input select-async-search__name" value="{{ $date_item_name ?? ''}}" type="text" required
            readonly>
        <input type="radio" name="okved_id" value="{{ $data_item_id ?? '' }}" hidden>
    </div>
    <div class="select-async-search__content">
        <div class="select-async-search__block">
            <input class="input select-async-search__search" placeholder="{{ $placeholder ?? '' }}" type="search">
        </div>
        <ul class="select-async-search__list"></ul>
        <div class="select-async-search__observer"></div>
    </div>
</div>
