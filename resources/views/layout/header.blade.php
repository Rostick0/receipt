<header class="header">
    <div class="container header__container">
        <nav class="header__nav">
            <a class="header__nav_item" href="/">Чеки</a>
            @auth
                <a class="header__nav_item" href="{{ route('receipt.create') }}">Добавить чек</a>

                @if (auth()->user()->hasRole('admin'))
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
</header>
