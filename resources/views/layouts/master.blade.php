<!doctype html>
<html lang="RU">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
@include('components.head')
{!! $head_scripts !!}
<body>
{!! $after_body_scripts !!}
<div id="app" class="wrapper">
    <button onclick="topFunction()" id="myBtn" class="arrow-to-top">
        <span class="icon-arrow-up2"></span>
    </button>
    <header class="header">
        <header-component
            index-route="{{route('home')}}"
            exchange-policy-route="{{route('exchange-policy')}}"
            privacy-policy-route="{{route('privacy-policy')}}"
            logo-app="{{asset('storage/img/content/logo.png')}}"
            app-name="{{env('APP_NAME')}}"
            app-phone="{{$phone}}"
            app-email="{{$email}}"
            app-facebook="{{$facebook}}"
            app-instagram="{{$instagram}}"
            app-schedule="{!! $schedule !!}"
            app-telegram="{{$telegram}}"
            app-viber="{{$viber}}"
        ></header-component>
    </header>
    <main class="main">
        @include('components.modal-burger-menu')
        @yield('content')
    </main>
    <footer class="footer">
        @include('components.footer')
    </footer>
</div>
<script>
    mybutton = document.getElementById("myBtn");

    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
<script src="https://unpkg.com/smoothscroll-anchor-polyfill"></script>
@include('components.footer-scripts')
{!! $footer_scripts !!}
</body>
</html>
