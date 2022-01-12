<!doctype html>
<html lang="RU">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
@include('components.head')
{!! $options['head_scripts']->value !!}
<body>
{!! $options['after_body_scripts']->value !!}
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
            app-phone="{{$options['phone']->value}}"
            app-email="{{$options['email']->value}}"
            app-facebook="{{$options['facebook']->value}}"
            app-instagram="{{$options['instagram']->value}}"
            app-schedule="{!! $options['schedule']->value !!}"
            app-telegram="{{$options['telegram']->value}}"
            app-viber="{{$options['viber']->value}}"
        ></header-component>
    </header>
    <main class="main">
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
{!! $options['footer_scripts']->value !!}
</body>
</html>
