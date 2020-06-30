<div id="top-bar" class="container">
    <div class="d-flex">
        <div class="mr-auto ">
            <form method="POST" class="search_form">
                <input type="text" class="input-block-level search-query text-black-50" Placeholder="eg. T-sirt">
            </form>
        </div>
        <div class="account ">
            <ul class="user-menu">


                    @guest()
                        <li><a href={{ route('login') }}>Ingresar</a></li>
                    @else
                        <li><a href="{{ route('pages.user-account.update', auth()->user()) }}">Mi cuenta</a></li>

                        @if(auth()->user()->hasRole('Admin'))
                        <li><a href={{ route('admin.dashboard') }}>Administración</a></li>
                        @else

                            <li><a href="{{ route('pages.your-car') }}">Tu carrito</a></li>
                            <li><a href="{{ route('pages.checkout') }}">Checkout</a></li>
                        @endif

                        <li>
                            <a href='#'
                               onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();"
                            >Cerrar sesión</a>
                        </li>
                    @endguest

            </ul>
        </div>
    </div>
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" display="none">
    @csrf
</form>


<div id="wrapper" class="container">
    <section class="navbar-nav">
        <div class="navbar-inner main-menu d-flex mb-4">
            <a href="{{ route('home') }}" class="mr-auto"><img src="/shooper/themes/images/logo.png" class="site_logo" alt=""></a>
            <nav id="menu" class="">
                <ul>
                    <li><a href="#_">Woman</a>
                        <ul>
                            <li><a href="#">Lacinia nibh</a></li>
                            <li><a href="#">Eget molestie</a></li>
                            <li><a href="#">Varius purus</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Man</a></li>
                    <li><a href="#">Sport</a>
                        <ul>
                            <li><a href="#">Gifts and Tech</a></li>
                            <li><a href="#">Ties and Hats</a></li>
                            <li><a href="#">Cold Weather</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Hangbag</a></li>
                    <li><a href="#">Best Seller</a></li>
                    <li><a href="#">Top Seller</a></li>
                </ul>
            </nav>
        </div>
    </section>
