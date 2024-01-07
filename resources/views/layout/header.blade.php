<header class="header">
    <div class="container header__container">
        <nav class="header__nav">
            <a class="header__nav_item" href="/">Мои чеки</a>
            @auth
                <a class="header__nav_item" href="">Мои чеки</a>
                <a class="header__nav_item" href="{{ route('receipt.create') }}">Добавить чек</a>
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
