<?php

use App\Http\Controllers\Admin\Api\AdminController;
use App\Http\Controllers\Admin\Api\Bookkeeping\DailyStatisticsController;
use App\Http\Controllers\Admin\Api\Bookkeeping\SupplierPaymentsController;
use App\Http\Controllers\Admin\Api\CategoriesController;
use App\Http\Controllers\Admin\Api\ColorsController;
use App\Http\Controllers\Admin\Api\OrderItemsController;
use App\Http\Controllers\Admin\Api\OrdersController;
use App\Http\Controllers\Admin\Api\ProductsController;
use App\Http\Controllers\Admin\Api\ProvidersController;
use App\Http\Controllers\Admin\Api\ReviewsController;
use App\Http\Controllers\Admin\Api\UploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Api\ClientsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** Группа маршрутов API для авторизованных пользователей. */
Route::middleware('auth:api')->group(function () {

    /**
     * Маршрут дашборда админ.панели.
     *
     * GET /api/dashboard
     */
    Route::get('dashboard', [AdminController::class, 'dashboard'])
        ->name('api.dashboard');

    Route::prefix('products')->group(function () {

        Route::get('/', [ProductsController::class, 'index'])
            ->name('api.products.index');

        Route::get('edit/{id}', [ProductsController::class, 'edit'])
            ->name('api.products.edit');

        Route::put('update/{id}', [ProductsController::class, 'update'])
            ->name('api.products.update');

        Route::post('create', [ProductsController::class, 'create'])
            ->name('api.products.create');

        Route::delete('destroy/{id}', [ProductsController::class, 'destroy'])
            ->name('api.products.destroy');

        Route::get('search={search}', [ProductsController::class, 'search'])
            ->name('api.products.search');

        Route::post('update-sort/{id}', [ProductsController::class, 'updateSort'])
            ->name('api.products.updateSort');

        Route::post('mass', [ProductsController::class, 'massActions'])
            ->name('api.products.mass');

        Route::prefix('colors')->group(function () {

            Route::get('get/{id}', [ProductsController::class, 'getProductColors'])
                ->name('api.products.colors.get');

            Route::post('attach/{id}', [ProductsController::class, 'attachColor'])
                ->name('api.products.colors.add');

            Route::post('detach/{id}', [ProductsController::class, 'detachColor'])
                ->name('api.products.colors.detach');
        });

        Route::prefix('images')->group(function () {
            Route::post('upload', [UploadController::class, 'uploadProductImages'])
                ->name('api.products.images.upload');
        });

    });

    Route::prefix('colors')->group(function () {
        Route::get('list', [ColorsController::class, 'list'])
            ->name('api.colors.list');
    });

    /** Группа маршрутов для клиентского раздела */
    Route::prefix('clients')->group(function () {

        /** GET /api/clients */
        Route::get('/', [ClientsController::class, 'index'])
            ->name('api.clients.index');

        /** GET /api/clients/edit/{id} */
        Route::get('edit/{id}', [ClientsController::class, 'edit'])
            ->name('api.clients.edit');

        /** GET /api/clients/update/{id} */
        Route::put('update/{id}', [ClientsController::class, 'update'])
            ->name('api.clients.update');

        /** POST /api/clients/search={search} */
        Route::get('search={search}', [ClientsController::class, 'search'])
            ->name('api.clients.search');

        /** DELETE /api/clients/destroy/{id} */
        Route::delete('/destroy/{id}', [ClientsController::class, 'destroy'])
            ->name('api.clients.destroy');

        /** POST /api/clients/mass */
        Route::post('mass', [ClientsController::class, 'massActions'])
            ->name('api.clients.mass');
    });

    /** Группа маршрутов для заказов */
    Route::prefix('orders')->group(function () {

        /**
         * Получить все заказы.
         *
         * GET /api/orders
         */
        Route::get('/', [OrdersController::class, 'index'])
            ->name('api.orders.index');

        Route::get('filter', [OrdersController::class, 'filter'])
            ->name('api.orders.filter');
        /**
         * Поиск клиентов по базе
         *
         * POST /api/orders/search={search}
         */
        Route::get('/search={search}', [OrdersController::class, 'search'])
            ->name('api.orders.search');

        /**
         * Удаление заказ по ID.
         *
         * DELETE /api/orders/destroy/{id}
         */
        Route::delete('/destroy/{id}', [OrdersController::class, 'destroy'])
            ->name('api.orders.destroy');

        /**
         * Получить заказ по ID для редактирования.
         *
         * GET /api/orders/edit/{id}
         */
        Route::get('/edit/{id}', [OrdersController::class, 'edit'])
            ->name('api.orders.edit');

        /**
         * Обновить заказ по ID.
         *
         * PUT /api/orders/update/{id}
         */
        Route::put('/update/{id}', [OrdersController::class, 'update'])
            ->name('api.orders.update');

        /** POST /api/orders/mass */
        Route::post('mass', [OrdersController::class, 'massActions'])
            ->name('api.orders.mass');
    });

    /** Группа маршрутов для элементов заказа */
    Route::prefix('order-items')->group(function () {

        /**
         * Получить элементы по ID заказа.
         *
         * GET /api/order-items/{id}
         */
        Route::get('{id}', [OrderItemsController::class, 'getByOrderId'])
            ->name('api.order-items.getByOrderId');

        /**
         * Удаление элемента заказа по ID.
         *
         * DELETE /api/order-items/destroy/{id}
         */
        Route::delete('destroy/{id}', [OrderItemsController::class, 'destroy'])
            ->name('api.order-items.destroy');

        /**
         * Обновить данные элемента заказа.
         *
         * PUT /api/order-items/update/{id}
         */
        Route::put('/update/{id}', [OrderItemsController::class, 'update'])
            ->name('api.order-items.update');

        /**
         * Обноить статус выплаты.
         *
         * PUT /api/order-items/update-pay-status/{id}
         */
        Route::put('/update-pay-status/{id}', [OrderItemsController::class, 'updatePayStatus'])
            ->name('api.order-items.update-pay-status');

        /**
         * Получить элемент заказа для редактирования.
         *
         * GET /api/order-items/edit/{id}
         */
        Route::get('/edit/{id}', [OrderItemsController::class, 'edit'])
            ->name('api.order-items.edit');
    });

    Route::prefix('providers')->group(function () {
        Route::get('list', [ProvidersController::class, 'list'])
            ->name('api.providers.list');
    });

    /** Группа маршрутов для бухгалтерии */
    Route::prefix('bookkeeping')->group(function () {

        Route::prefix('daily-statistics')->group(function () {

            /**
             * Получить всю статистику по дням.
             *
             * GET /api/bookkeeping/daily-statistics
             */
            Route::get('/', [DailyStatisticsController::class, 'index'])
                ->name('api.bookkeeping.daily_statistics.index');

            /**
             * Добавить новую дату в статистику.
             *
             * GET /api/bookkeeping/daily-statistics/create
             */
            Route::get('create', [DailyStatisticsController::class, 'create'])
                ->name('api.bookkeeping.daily_statistics.create');

            /**
             * Сортировать статистику по диапазону дат.
             *
             * GET /api/bookkeeping/daily-statistics/date-range
             */
            Route::get('date-range', [DailyStatisticsController::class, 'dateRange'])
                ->name('api.bookkeeping.daily_statistics.dateRange');

        });

        /** Группа маршрутов для страницы с информацией о выплатах. */
        Route::prefix('supplier-payments')->group(function () {

            /**
             * Получить все заказы, ожидающие выплаты.
             *
             * GET /api/bookkeeping/supplier-payments
             */
            Route::get('/', [SupplierPaymentsController::class, 'index'])
                ->name('api.bookkeeping.supplier-payments.index');

            /**
             * Получить все заказы, ожидающие выплаты от поставщика.
             *
             * GET /api/bookkeeping/supplier-payments/payments-awaiting
             */
            Route::get('payments-awaiting', [SupplierPaymentsController::class, 'paymentsAwaiting'])
                ->name('api.bookkeeping.supplier-payments.paymentsAwaiting');

            /**
             * Получить все заказы, ожидающие выплаты от поставщика.
             *
             * GET /api/bookkeeping/supplier-payments/payments-received
             */
            Route::get('payments-received', [SupplierPaymentsController::class, 'paymentsReceived'])
                ->name('api.bookkeeping.supplier-payments.paymentsReceived');
        });
    });

    /** Группа маршрутов для категорий в аодминке */
    Route::prefix('categories')->group(function () {

        /**
         * Получить список всех категорий в пагинации
         *
         * GET /api/categories
         */
        Route::get('/', [CategoriesController::class, 'index'])
            ->name('api.categories.index');

        /**
         * Получить список всех категорий
         *
         * GET /api/categories/all
         */
        Route::get('all', [CategoriesController::class, 'all'])
            ->name('api.categories.all');

        /**
         * Создать новую категорию.
         *
         * POST /api/categories/create
         */
        Route::post('create', [CategoriesController::class, 'create'])
            ->name('api.categories.create');

        /**
         * Открыть страницу редактирования категории.
         *
         * GET /api/categories/edit/{id}
         */
        Route::get('edit/{id}', [CategoriesController::class, 'edit'])
            ->name('api.categories.edit');

        /**
         * Обновить данные категории.
         *
         * PUT /api/categories/update/{id}
         */
        Route::put('update/{id}', [CategoriesController::class, 'update'])
            ->name('api.categories.update');

        /**
         * Удалить категорию.
         *
         * DELETE /api/categories/destroy/{id}
         */
        Route::delete('destroy/{id}', [CategoriesController::class, 'destroy'])
            ->name('api.categories.destroy');

        Route::get('search={search}', [CategoriesController::class, 'search'])
            ->name('api.categories.search');

        Route::post('update-sort/{id}', [CategoriesController::class, 'updateSort'])
            ->name('api.categories.updateSort');

        Route::post('mass', [CategoriesController::class, 'massActions'])
            ->name('api.categories.mass');
    });

    Route::prefix('reviews')->group(function () {

        Route::get('/', [ReviewsController::class, 'index'])
            ->name('api.reviews.index');

        Route::get('edit/{id}', [ReviewsController::class, 'edit'])
            ->name('api.reviews.edit');

        Route::put('update/{id}', [ReviewsController::class, 'update'])
            ->name('api.reviews.update');

        Route::delete('destroy/{id}', [ReviewsController::class, 'destroy'])
            ->name('api.reviews.destroy');

        Route::post('accept/{id}', [ReviewsController::class, 'accept'])
            ->name('api.reviews.accept');

        Route::get('search={search}', [ReviewsController::class, 'search'])
            ->name('api.reviews.search');

        Route::post('mass', [ReviewsController::class, 'massActions'])
            ->name('api.reviews.mass');
    });

    /** Группа маргрутов для изображений */
    Route::prefix('images')->group(function () {

        Route::delete('destroy/{id}', [UploadController::class, 'destroyImage'])
            ->name('api.images.destroy');

        Route::post('preview-upload', [UploadController::class, 'uploadPreview'])
            ->name('api.images.uploadPreview');

//        /** Группа маршрутов для превью */
//        Route::prefix('preview-update')->group(function () {
//
//            /**
//             * Загрузить превью для категорий.
//             *
//             * POST /api/images/preview-update/categories
//             */
//            Route::post('categories', [UploadController::class, 'uploadCategoryPreview'])
//                ->name('api.images.upload.preview');
//        });
    });
});

require __DIR__ . '/api-v1.php';
