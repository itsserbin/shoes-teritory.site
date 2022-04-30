<!doctype html>
<html lang="RU">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#">
@include('components.head')
{!! $options['head_scripts']?->value !!}
<body>
{!! $options['after_body_scripts']?->value !!}
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
            app-phone="{{$options['phone']?->value}}"
            app-email="{{$options['email']?->value}}"
            app-facebook="{{$options['facebook']?->value}}"
            app-instagram="{{$options['instagram']?->value}}"
            app-schedule="{!! $options['schedule']?->value !!}"
            app-telegram="{{$options['telegram']?->value}}"
            app-viber="{{$options['viber']?->value}}"
            pages="{{json_encode($pages)}}"
            lang="{{app()->getLocale()}}"
            categories="{{$categories}}"

            setlocate-ru="{{route('setlocale',['lang' => 'ru'])}}"
            setlocate-ua="{{route('setlocale',['lang' => 'ua'])}}"
            cart-route="{{route('cart')}}"
            category-route="{{route('category')}}"
        ></header-component>
    </header>
    <main class="main">
        @yield('content')
        <faq-component
            lang="{{app()->getLocale()}}"
            text-faq-heading="@lang('home.text_faq_heading')"
        ></faq-component>
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
<!-- Facebook Pixel Code -->
<script>
    !function (f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function () {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', {{env('FB_PIXEL_ID')}});
    fbq('track', 'PageView');
</script>
<noscript>
    <img height="1" width="1" style="display:none"
         src="'https://www.facebook.com/tr?id={{env('FB_PIXEL_ID')}}&ev=PageView&noscript=1'"
    />
</noscript>
<!-- End Facebook Pixel Code -->
<script src="https://unpkg.com/smoothscroll-anchor-polyfill"></script>
@include('components.footer-scripts')
{!! $options['footer_scripts']?->value !!}
</body>
</html>
