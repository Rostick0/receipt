<header class="header">
    <div class="container header__container">
        <nav class="header__nav">
            <a class="header__nav_item" href="/">Чеки</a>
            @auth
                <a class="header__nav_item" href="">Мои чеки</a>
                <a class="header__nav_item" href="">Добавить чек</a>
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
