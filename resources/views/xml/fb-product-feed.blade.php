@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>Dabango Products Feed</title>
        <description>Product Feed for Facebook</description>
        <link>{{asset('/')}}</link>
        @if(\Illuminate\Support\Facades\Route::is('xml.fb.underwear'))
            <atom:link href="{{route('xml.fb.underwear')}}" rel="self" type="application/rss+xml"/>
        @elseif(\Illuminate\Support\Facades\Route::is('xml.fb.swimwear-and-tunics'))
            <atom:link href="{{route('xml.fb.swimwear-and-tunics')}}" rel="self" type="application/rss+xml"/>
        @elseif(\Illuminate\Support\Facades\Route::is('xml.fb.all'))
            <atom:link href="{{route('xml.fb.all')}}" rel="self" type="application/rss+xml"/>
        @else
            <atom:link href="{{route('xml.fb.top-swimwear-and-tunics')}}" rel="self" type="application/rss+xml"/>
        @endif
        @if (!empty($products))
            @foreach ($products as $item)
                <item>
                    <id>{{ $item->id }}</id>
                    <title>{{ $item->h1 }}</title>
                    <description>{{$item->content}}</description>
                    <availability>
                        @if($item->status == 'Нет в наличии')
                            out of stock
                        @else
                            in stock
                        @endif
                    </availability>
                    <brand>Dabango</brand>
                    <condition>new</condition>
                    <price>{{$item->discount_price ?: $item->price}}</price>
                    <link>{{asset(route('product',$item->id))}}</link>
                    <image_link>{{asset('/storage/preview/' . $item->preview)}}</image_link>
                    <additional_image_link>
                        @foreach($item->images as $item)
                            {{asset('/storage/products/'.$item->image).',' }}
                        @endforeach
                    </additional_image_link>
                    <gender>female</gender>
                    <fb_product_category>Clothing and Accessories > Clothing > Women's Clothing</fb_product_category>
                    <google_product_category>Apparel and Accessories > Clothing</google_product_category>
                </item>
            @endforeach
        @endif
    </channel>
</rss>
