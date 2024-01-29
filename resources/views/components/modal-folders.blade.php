<div class="modal modal-folders">
    <div class="modal__inner modal-folders__inner">
        <div class="modal-folders__list">
            {{-- @auth
                @if (auth()->user()->folders()->count())
                    @foreach (auth()->user()->folders()->limit(50)->get() as $folder)
                        <label class="checbox modal-folders__checkbox">
                            <input class="checbox__input modal-folders__input" type="checkbox" value="{{ $folder->id }}">
                            <span class="checbox__icon"></span>
                            <span class="label__title">{{ $folder->name }}</span>
                        </label>
                    @endforeach
                @else
                    <span>Отсутствуют папки, вы можете <a class="link"
                            href="{{ route('folder.create') }}">создать</a></span>
                @endif
            @endauth --}}
        </div>
        <button class="btn modal-folders__btn">Сохранить</button>
    </div>
</div>
