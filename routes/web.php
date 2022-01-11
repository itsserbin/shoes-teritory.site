<?php

use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Auth;
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
Route::get('/category/{slug}', [HomeController::class, 'category'])
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

/**
 * Открыть robots.txt
 *
 * GET /robots.txt
 */
Route::get('robots.txt', [HomeController::class, 'robots'])
    ->name('robots');



Route::prefix('xml')->group(function(){

    Route::prefix('fb')->group(function(){

        Route::get('all', [HomeController::class, 'xmlFbAll'])
            ->name('xml.fb.all');
        
        Route::get('underwear', [HomeController::class, 'xmlFbUnderwear'])
            ->name('xml.fb.underwear');

        Route::get('swimwear-and-tunics', [HomeController::class, 'xmlFbSwimwearAndTunics'])
            ->name('xml.fb.swimwear-and-tunics');

        Route::get('top-swimwear-and-tunics', [HomeController::class, 'xmlFbTopSwimwearAndTunics'])
            ->name('xml.fb.top-swimwear-and-tunics');
    });


    Route::get('prom/feed/products', [HomeController::class, 'promProductFeed'])
        ->name('prom.product.feed');
});


/**
 * Показать страницу благодарности после отправки заявки.
 *
 * GET /send-form
 */
Route::get('send-form', [HomeController::class, 'send_form_get'])
    ->name('send.form.get');

/**
 * Отправить форму отзыва.
 *
 * POST /send-review/
 */
Route::post('send-review', [HomeController::class, 'send_review_post'])
    ->name('send.review.post');

Auth::routes();

require __DIR__ . '/admin.php';
