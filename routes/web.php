<?php

use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\XmlController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function () {
    /**
     * Открыть главную страницу.
     *
     * GET /
     */
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    /**
     * Открыть корзину.
     *
     * GET /cart/
     */
    Route::get('cart', [CartController::class, 'index'])
        ->name('cart');

    /**
     * Открыть страницу подтверждения заказа.
     */
    Route::get('checkout', [HomeController::class, 'checkout'])
        ->name('checkout');

    Route::get('cart', [HomeController::class, 'cart'])
        ->name('cart');

    /**
     * Открыть страницу товара.
     *
     * GET /product/{id}
     */
    Route::get('/product/{id?}', [HomeController::class, 'product'])
        ->name('product');

    /**
     * Открыть страницу категории.
     *
     * GET /category/{slug}
     */
    Route::get('/category/{slug?}', [HomeController::class, 'category'])
        ->name('category');

    /**
     * Открыть политику конфеденциальности
     *
     * GET /privacy-policy
     */
    Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])
        ->name('privacy-policy');

    /**
     * Открыть политику обмена и возврата.
     *
     * GET /exchange-policy
     */
    Route::get('exchange-policy', [HomeController::class, 'exchangePolicy'])
        ->name('exchange-policy');

    /**
     * Открыть карту сайта XML
     *
     * GET /sitemap.xml
     */
    Route::get('sitemap.xml', [HomeController::class, 'sitemap'])
        ->name('sitemap');

    /**
     * Открыть карту изображений XML
     *
     * GET /images_sitemap.xml
     */
    Route::get('images_sitemap.xml', [HomeController::class, 'imagesSitemap'])
        ->name('images-sitemap');

    Route::get('pages/{slug}', [HomeController::class, 'page'])
        ->name('pages');

    Route::prefix('xml')->group(function () {

        Route::prefix('fb')->group(function () {

            Route::get('all', [XmlController::class, 'xmlFbAll'])
                ->name('xml.fb.all');

            Route::get('underwear', [XmlController::class, 'xmlFbUnderwear'])
                ->name('xml.fb.underwear');

            Route::get('big-size', [XmlController::class, 'xmlFbBigSize'])
                ->name('xml.fb.big-size');

            Route::get('swimwear-and-tunics', [XmlController::class, 'xmlFbSwimwearAndTunics'])
                ->name('xml.fb.swimwear-and-tunics');

            Route::get('top-swimwear-and-tunics', [XmlController::class, 'xmlFbTopSwimwearAndTunics'])
                ->name('xml.fb.top-swimwear-and-tunics');

            Route::get('top-swimwear', [XmlController::class, 'xmlFbTopSwimwear'])
                ->name('xml.fb.top-swimwear');

            Route::get('top-underwear', [XmlController::class, 'xmlFbTopUnderwear'])
                ->name('xml.fb.top-underwear');

            Route::get('swimwear-and-tunics-5xl', [XmlController::class, 'xmlFbSwimwearAndTunics5Xl'])
                ->name('xml.fb.swimwear-and-tunics-5xl');

            Route::get('fitness', [XmlController::class, 'xmlFbFitness'])
                ->name('xml.fb.fitness');
        });


        Route::get('prom/feed/products', [XmlController::class, 'promProductFeed'])
            ->name('prom.product.feed');
    });
});


/**
 * Открыть robots.txt
 *
 * GET /robots.txt
 */
Route::get('robots.txt', [HomeController::class, 'robots'])
    ->name('robots');


Route::get('send-form', [HomeController::class, 'send_form_get'])
    ->name('send.form.get');
/**
 * Отправить форму отзыва.
 *
 * POST /send-review/
 */
Route::post('send-review', [HomeController::class, 'send_review_post'])
    ->name('send.review.post');

//Auth::routes();

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';

//Переключение языков
Route::get('setlocale/{lang}', function ($lang) {

    $referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
    $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

    //разбиваем на массив по разделителю
    $segments = explode('/', $parse_url);

    //Если URL (где нажали на переключение языка) содержал корректную метку языка
    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {

        unset($segments[1]); //удаляем метку
    }

    //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
    if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage) {
        array_splice($segments, 1, 0, $lang);
    }

    //формируем полный URL
    $url = request()->root() . implode("/", $segments);

    //если были еще GET-параметры - добавляем их
    if (parse_url($referer, PHP_URL_QUERY)) {
        $url = $url . '?' . parse_url($referer, PHP_URL_QUERY);
    }
    return redirect($url); //Перенаправляем назад на ту же страницу

})->name('setlocale');
