<div class="content">
    <div class="row text-center">
        <div class="col-12 col-md-3">
            <address class="footer__address address">

                @if(isset($options['phone']->value))
                    <a href="tel:{{$options['phone']->value}}"
                       class="phonecall text-decoration-none">{{$options['phone']->value}}</a>
                @endif

                @if(isset($options['email']->value))
                    <a href="mailto:{{$options['email']->value}}"
                       class="email text-decoration-none">{{$options['email']->value}}</a>
                @endif

            </address>
        </div>
        <div class="col-12 col-md-3">
            <div class="footer__social-buttons social-buttons">

                @if(isset($options['facebook']->value))
                    <a href="{{$options['facebook']->value}}" target="_blank">
                        <facebook-icon></facebook-icon>
                    </a>
                @endif

                @if(isset($options['instagram']->value))
                    <a href="{{$options['instagram']->value}}" target="_blank">
                        <instagram-icon></instagram-icon>
                    </a>
                @endif
            </div>
        </div>
        <div class="col-12 col-md-3">
            @if(isset($options['schedule']->value))
                <div class="footer__title">График работы</div>
                <div class="footer__schedule schedule">
                    <span>{!! $options['schedule']->value !!}</span>
                </div>
            @endif
        </div>
        @if(isset($options['telegram']->value))
            <div class="col-12 col-md-3">
                <div class="footer__messengers messengers">
                    <a href="{{$options['telegram']->value}}" target="_blank">
                        <telegram-icon></telegram-icon>
                    </a>
                    @endif
                    @if(isset($options['viber']->value))
                        <a href="{{$options['viber']->value}}" target="_blank">
                            <viber-icon></viber-icon>
                        </a>
                </div>
            </div>
        @endif
    </div>
    <div class="row text-center">
        @foreach($pages as $page)
            <a href="{{route('pages',$page->slug)}}"
               class="text-decoration-none text-white mb-3"
            >{{app()->getLocale() == 'ua' ? $page->heading['ua'] : $page->heading['ru']}}</a>
        @endforeach
    </div>
</div>
