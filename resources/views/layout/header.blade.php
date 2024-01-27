<header class="header">
    <div class="container header__container">
        <div class="header__container_top">
            <nav class="header__nav">
                <a class="header__nav_item" href="/">Чеки</a>
                @auth
                    <a class="header__nav_item" href="{{ route('receipt.create') }}">Добавить чек</a>

                    @if (auth()->user()->hasRole('admin'))
                        <a class="header__nav_item" href="{{ route('receipt.trash') }}">Корзина чеков</a>
                        <a class="header__nav_item" href="{{ route('okved.index') }}">Список ОКВЭД</a>
                        <a class="header__nav_item" href="{{ route('okved.create') }}">Добавить ОКВЭД</a>
                    @endif
                @endauth
            </nav>
            @guest
                <a class="btn header__btn" href="{{ route('login') }}">Войти</a>
            @endguest
            @auth
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="link header__btn">Выйти</button>
                </form>
            @endauth
        </div>
        @auth
            <div class="header__container_bottom header-folder">
                <a class="header-folder__create" href="{{ route('folder.create') }}"></a>
                @if (auth()->user()->folders()->count())
                    <div class="header-folder__list">
                        @foreach (auth()->user()->folders as $item)
                            <a class="header-folder__item"
                                href="{{ route('folder.show', ['folder' => $item->id]) }}">{{ $item->name }}</a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endauth
    </div>
</header>
