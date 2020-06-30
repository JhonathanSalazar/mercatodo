
    <section id="footer-bar">
        <div class="row">
            <div class="col-md-3">
                <h4>Navegación</h4>
                <ul class="navbar-nav">
                    <li><a href="{{ route('home') }}">Página inicio</a></li>
                    <li><a href="{{ route('pages.about') }}">Acerca de nosotros</a></li>
                    <li><a href="{{ route('pages.contact') }}">Contactanos</a></li>
                    <li><a href="{{ route('pages.your-car') }}">Tu carrito</a></li>
                    <li><a href="{{ route('login') }}">Ingresa</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>Mi cuenta</h4>
                <ul class="navbar-nav">
                    <li><a href="{{ route('pages.user-account.update', auth()->user()) }}">Mi cuenta</a></li>
                    <li><a href="#">Historial de compras</a></li>
                    <li><a href="#">Lista de deseos</a></li>
                </ul>
            </div>
            <div class="col-md-5">
                <p class="logo"><img src="/shooper/themes/images/logo.png" class="site_logo" alt=""></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. the  Lorem Ipsum has been the industry's standard dummy text ever since the you.</p>
                <br/>
                <span class="social">
                                <a class="facebook" href="#">Facebook</a>
                                <a class="twitter" href="#">Twitter</a>
                                <a class="skype" href="#">Skype</a>
                                <a class="vimeo" href="#">Vimeo</a>
                            </span>
            </div>
        </div>
    </section>
    <section id="copyright">
        <span>Copyright 2013 bootstrap page template  All right reserved.</span>
    </section>
</div>
<script src="/shooper/themes/js/common.js"></script>
<script src="/shooper/themes/js/jquery.flexslider-min.js"></script>
<script type="text/javascript">
    $(function() {
        $(document).ready(function() {
            $('.flexslider').flexslider({
                animation: "fade",
                slideshowSpeed: 4000,
                animationSpeed: 600,
                controlNav: false,
                directionNav: true,
                controlsContainer: ".flex-container" // the container that holds the flexslider
            });
        });
    });
</script>
</body>
</html>
