@if(count($advantages))
    <section id="advantages" class="advantages mb-3">
        <div class="content">
            <div class="row">
                @foreach($advantages as $advantage)
                    <div class="col text-center mb-3">
                        {!! $advantage->icon !!}
                        <h3 class="advantages__label">{{app()->getLocale() == 'ua' ? $advantage->text['ua'] : $advantage->text['ru'] }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
