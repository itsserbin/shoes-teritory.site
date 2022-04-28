<?php

use App\Http\Controllers\Api\Public\BannersController;
use App\Http\Controllers\Api\Public\CartController;
use App\Http\Controllers\Api\Public\CategoriesController;
use App\Http\Controllers\Api\Public\FaqController;
use App\Http\Controllers\Api\Public\OrdersController;
use App\Http\Controllers\Api\Public\ProductsController;
use App\Http\Controllers\Api\Public\ReviewsController;
use App\Http\Controllers\Api\Public\UsersController;
use Illuminate\Support\Facades\Route;

/** Public API */
Route::prefix('v1')->middleware('api')->group(function () {

    /** Route group for reviews */
    Route::prefix('reviews')->group(function () {

        /** Route for get list reviews */
        Route::get('list', [ReviewsController::class, 'list'])
            ->name('api.v1.public.reviews.list');

        Route::get('product/{id}', [ReviewsController::class, 'getProductReviews'])
            ->name('api.v1.public.reviews.product');
    });

    /** Route group for products */
    Route::prefix('product')->group(function () {

        /**
         * Get all items.
         *
         * GET /api/product
         */
        Route::get('/', [ProductsController::class, 'index'])
            ->name('api.v1.product.index');

        /**
         * Get item by ID.
         *
         * GET /api/product/show/{id}
         */
        Route::get('show/{id}', [ProductsController::class, 'getProduct'])
            ->name('api.v1.products.show');

        /**
         * Получить цвета по ID товара.
         *
         * GET /api/product/colors/{id}
         */
        Route::get('colors/{id}', [ProductsController::class, 'getProductColors'])
            ->name('api.v1.product.colors.show');

        Route::get('get-images/{id}', [ProductsController::class, 'getImages'])
            ->name('api.v1.public.products.images.get');

        Route::get('relative/{id}', [ProductsController::class, 'getRelativeProducts'])
            ->name('api.v1.products.relative.get');

        Route::get('best-selling', [ProductsController::class, 'getBestSelling'])
            ->name('api.v1.products.best-selling');

        Route::get('category/{slug}', [ProductsController::class, 'getWhereCategorySlug'])
            ->name('api.v1.products.category');

        Route::get('recommend-products', [ProductsController::class, 'getRecommendProducts'])
            ->name('api.v1.products.recommend');

        Route::get('best-selling-products', [ProductsController::class, 'getBestSellingProducts'])
            ->name('api.v1.products.best-selling-products');

        Route::get('new-products', [ProductsController::class, 'getNewProducts'])
            ->name('api.v1.products.new-products');
    });

    /** Группа маршрутов для корзины */
    Route::prefix('cart')->group(function () {

        /**
         * Показать товары в корзину.
         *
         * GET /api/cart/list
         */
        Route::get('list', [CartController::class, 'list'])
            ->name('api.v1.cart.list');

        /**
         * Добавить товар в корзину.
         *
         * POST /api/cart/add
         */
        Route::post('add', [CartController::class, 'add'])
            ->name('api.v1.cart.add');

        /**
         * Удалить товар из корзины.
         *
         * DELETE /api/cart/delete/{item}
         */
        Route::delete('delete/{item}', [CartController::class, 'delete'])
            ->name('api.v1.cart.delete');

        /**
         * Обновить инфу в корзине.
         *
         * POST /api/cart/update/
         */
        Route::post('update', [CartController::class, 'update'])
            ->name('api.v1.cart.update');

        Route::post('update-decrement/{id}', [CartController::class, 'updateDecrement'])
            ->name('api.v1.cart.update.decrement');

        Route::post('update-increment/{id}', [CartController::class, 'updateIncrement'])
            ->name('api.v1.cart.update.increment');

        Route::prefix('promo-code')->group(function () {
            Route::post('activate', [CartController::class, 'activatePromoCode'])
                ->name('api.v1.cart.promo.code.activate');

            Route::post('deactivate', [CartController::class, 'deactivatePromoCode'])
                ->name('api.v1.cart.promo.code.deactivate');
        });
    });

    /** Группа маршрутов для заказов */
    Route::prefix('order')->group(function () {

        /**
         * Route for create new order.
         *
         * POST /api/order/create
         */
        Route::post('create', [OrdersController::class, 'create'])
            ->name('api.v1.orders.create');
    });

    /** Группа маршрутов для категорий */
    Route::prefix('category')->group(function () {

        /**
         * Получить категории для вывода на продакшн.
         *
         * GET /api/category/all-on-prod
         */
        Route::get('all-on-prod', [CategoriesController::class, 'getAll'])
            ->name('api.v1.category.getAllOnProd');

        /**
         * Получить отдельную категорию.
         *
         * GET /api/category/{slug}
         */
        Route::get('{slug}', [CategoriesController::class, 'getBySlug'])
            ->name('api.v1.category.getCategoryOnProduction');

        /**
         * Получить товары из определенной категории..
         *
         * GET /api/category/products/{slug}
         */
//        Route::get('products/{slug}', [CategoriesController::class, 'getCategoryProducts'])
//            ->name('api.category.getCategoryProductsOnProduction');
    });

    Route::prefix('user')->group(function () {

        Route::get('info', [UsersController::class, 'getUserInfo'])
            ->name('api.v1.user.info');
    });

    Route::prefix('banners')->group(function () {
        Route::get('all', [BannersController::class, 'all'])
            ->name('api.v1.banners.all');
    });

    Route::get('faq/list', [FaqController::class, 'list'])
        ->name('api.v1.faq.list');
});
