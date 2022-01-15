<?php

use App\Http\Controllers\Public\Api\CartController;
use App\Http\Controllers\Public\Api\CategoriesController;
use App\Http\Controllers\Public\Api\OrdersController;
use App\Http\Controllers\Public\Api\ProductsController;
use App\Http\Controllers\Public\Api\ReviewsController;
use App\Http\Controllers\Public\Api\UsersController;
use Illuminate\Support\Facades\Route;

/** Public API */
Route::prefix('v1')->middleware('api')->group(function () {

    /** Route group for reviews */
    Route::prefix('reviews')->group(function () {

        /** Route for get list reviews */
        Route::get('list', [ReviewsController::class, 'list'])
            ->name('api.public.reviews.list');
    });

    /** Route group for products */
    Route::prefix('product')->group(function () {

        /**
         * Get all items.
         *
         * GET /api/product
         */
        Route::get('/', [ProductsController::class, 'index'])
            ->name('api.product.index');

        /**
         * Get item by ID.
         *
         * GET /api/product/show/{id}
         */
        Route::get('show/{id}', [ProductsController::class, 'getProduct'])
            ->name('api.products.show');

        /**
         * Получить цвета по ID товара.
         *
         * GET /api/product/colors/{id}
         */
        Route::get('colors/{id}', [ProductsController::class, 'getProductColors'])
            ->name('api.product.colors.show');

        Route::get('get-images/{id}', [ProductsController::class, 'getImages'])
            ->name('api.public.products.images.get');

        Route::get('reviews/{id}', [ProductsController::class, 'getReviews'])
            ->name('api.public.products.reviews.get');

        Route::get('relative/{id}', [ProductsController::class, 'getRelativeProducts'])
            ->name('api.public.products.relative.get');

        Route::get('best-selling', [ProductsController::class, 'getBestSellingProducts'])
            ->name('api.public.products.best-selling');

        Route::get('category/{slug}', [ProductsController::class, 'getWhereCategorySlug'])
            ->name('api.public.products.category');

        Route::get('recommend-products', [ProductsController::class, 'getRecommendProducts'])
            ->name('api.public.products.recommend');
    });

    /** Группа маршрутов для корзины */
    Route::prefix('cart')->group(function () {

        /**
         * Показать товары в корзину.
         *
         * GET /api/cart/list
         */
        Route::get('list', [CartController::class, 'list'])
            ->name('api.cart.list');

        /**
         * Добавить товар в корзину.
         *
         * POST /api/cart/add
         */
        Route::post('add', [CartController::class, 'add'])
            ->name('api.cart.add');

        /**
         * Удалить товар из корзины.
         *
         * DELETE /api/cart/delete/{item}
         */
        Route::delete('delete/{item}', [CartController::class, 'delete'])
            ->name('api.cart.delete');

        /**
         * Обновить инфу в корзине.
         *
         * POST /api/cart/update/
         */
        Route::post('update', [CartController::class, 'update'])
            ->name('api.cart.update');

        Route::post('update-decrement/{id}', [CartController::class, 'updateDecrement'])
            ->name('api.cart.update.decrement');

        Route::post('update-increment/{id}', [CartController::class, 'updateIncrement'])
            ->name('api.cart.update.increment');

        Route::prefix('promo-code')->group(function () {
            Route::post('activate', [CartController::class, 'activatePromoCode'])
                ->name('api.cart.promo.code.activate');

            Route::post('deactivate', [CartController::class, 'deactivatePromoCode'])
                ->name('api.cart.promo.code.deactivate');
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
            ->name('api.orders.create');
    });

    /** Группа маршрутов для категорий */
    Route::prefix('category')->group(function () {

        /**
         * Получить категории для вывода на продакшн.
         *
         * GET /api/category/all-on-prod
         */
        Route::get('all-on-prod', [CategoriesController::class, 'getAll'])
            ->name('api.category.getAllOnProd');

        /**
         * Получить отдельную категорию.
         *
         * GET /api/category/{slug}
         */
        Route::get('{slug}', [CategoriesController::class, 'getBySlug'])
            ->name('api.category.getCategoryOnProduction');

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
            ->name('api.user.info');
    });
});
