<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvantagesController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\Bookkeeping\BookkeepingController;
use App\Http\Controllers\Admin\Bookkeeping\CostsController;
use App\Http\Controllers\Admin\Bookkeeping\ManagersSalariesController;
use App\Http\Controllers\Admin\Bookkeeping\MarketingStatisticController;
use App\Http\Controllers\Admin\Bookkeeping\OrdersStatisticController;
use App\Http\Controllers\Admin\Bookkeeping\ProfitController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ClientsController;
use App\Http\Controllers\Admin\ColorsController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\PromoCodesController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\RolesColroller;
use App\Http\Controllers\Admin\TranslationsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\Bookkeeping\ProductStatisticsController;
use App\Http\Controllers\Admin\Bookkeeping\ProvidersController;
use App\Http\Controllers\Admin\Bookkeeping\SupplierPaymentsController;
use App\Http\Controllers\Admin\OptionsController;
use Illuminate\Support\Facades\Route;


/** Группа маршрутов для админ.панели */
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {

    /**
     * Открыть главную страницу админки.
     *
     * GET /admin/dashboard
     */
    Route::get('dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    /** Группа маршрутов для картегорий */
    Route::prefix('categories')->group(function () {

        /**
         * Открыть страницу со всеми категориями.
         *
         * GET /admin/categories
         */
        Route::get('/', [CategoriesController::class, 'index'])
            ->name('admin.categories.index');

        /**
         * Открыть страницу создания категории.
         *
         * GET /admin/categories/create
         */
        Route::get('create', [CategoriesController::class, 'create'])
            ->name('admin.categories.create');

        /**
         * Открыть страницу редактирования категории.
         *
         * GET /admin/categories/edit
         */
        Route::get('edit/{id}', [CategoriesController::class, 'edit'])
            ->name('admin.categories.edit');
    });

    Route::prefix('products')->group(function () {

        Route::get('/', [ProductsController::class, 'index'])
            ->name('admin.products.index');

        Route::get('edit/{id}', [ProductsController::class, 'edit'])
            ->name('admin.products.edit');

        Route::get('create', [ProductsController::class, 'create'])
            ->name('admin.products.create');
    });

    Route::prefix('reviews')->group(function () {

        Route::get('/', [ReviewsController::class, 'index'])
            ->name('admin.reviews.index');

        Route::get('edit/{id}', [ReviewsController::class, 'edit'])
            ->name('admin.reviews.edit');

        Route::get('create', [ReviewsController::class, 'create'])
            ->name('admin.reviews.create');
    });

    Route::prefix('promo-codes')->group(function () {

        Route::get('/', [PromoCodesController::class, 'index'])
            ->name('admin.promo-codes.index');

        Route::get('edit/{id}', [PromoCodesController::class, 'edit'])
            ->name('admin.promo-codes.edit');

        Route::get('create', [PromoCodesController::class, 'create'])
            ->name('admin.promo-codes.create');
    });


    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientsController::class, 'index'])
            ->name('admin.clients.index');

        Route::get('/edit/{id}', [ClientsController::class, 'edit'])
            ->name('admin.clients.edit');

        Route::get('export', [ClientsController::class, 'export'])
            ->middleware('role:administrator')
            ->name('admin.clients.export');
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrdersController::class, 'index'])
            ->name('admin.orders.index');

        Route::get('/edit/{id}', [OrdersController::class, 'edit'])
            ->name('admin.orders.edit');

        Route::get('export', [OrdersController::class, 'export'])
            ->middleware('role:administrator')
            ->name('admin.orders.export');
    });

    Route::group(['prefix' => '/bookkeeping',], function () {
        Route::get('/', [BookkeepingController::class, 'index'])
            ->name('admin.bookkeeping.index');

        Route::prefix('costs')
            ->middleware('role:administrator')
            ->group(function () {
                Route::get('/', [CostsController::class, 'index'])
                    ->name('admin.bookkeeping.costs.index');

                Route::get('edit/{id}', [CostsController::class, 'edit'])
                    ->name('admin.bookkeeping.costs.edit');

                Route::get('create', [CostsController::class, 'create'])
                    ->name('admin.bookkeeping.costs.create');

                Route::prefix('categories')->group(function () {
                    Route::get('/', [\App\Http\Controllers\Admin\Bookkeeping\Costs\CategoriesController::class, 'index'])
                        ->name('admin.bookkeeping.costs.categories.index');

                    Route::get('create', [\App\Http\Controllers\Admin\Bookkeeping\Costs\CategoriesController::class, 'create'])
                        ->name('admin.bookkeeping.costs.categories.create');

                    Route::get('edit/{id}', [\App\Http\Controllers\Admin\Bookkeeping\Costs\CategoriesController::class, 'edit'])
                        ->name('admin.bookkeeping.costs.categories.edit');
                });
            });

        Route::prefix('profits')
            ->middleware('role:administrator')
            ->group(function () {
                Route::get('/', [ProfitController::class, 'index'])
                    ->name('admin.bookkeeping.profits.index');

                Route::get('create', [ProfitController::class, 'create'])
                    ->name('admin.bookkeeping.profits.create');
            });

        Route::prefix('orders-statistic')->group(function () {
            Route::get('/', [OrdersStatisticController::class, 'index'])
                ->name('admin.bookkeeping.orders-statistic.index');
        });

        Route::prefix('marketing-statistic')->group(function () {
            Route::get('/', [MarketingStatisticController::class, 'index'])
                ->name('admin.bookkeeping.marketing-statistic.index');
        });

        Route::resource('product-statistics', ProductStatisticsController::class)
            ->middleware('role:administrator')
            ->names('admin.bookkeeping.product-statistics');

        Route::prefix('providers')->group(function () {
            Route::get('/', [ProvidersController::class, 'index'])
                ->name('admin.bookkeeping.providers.index');

            Route::get('create', [ProvidersController::class, 'create'])
                ->name('admin.bookkeeping.providers.create');

            Route::get('edit/{id}', [ProvidersController::class, 'edit'])
                ->name('admin.bookkeeping.providers.edit');
        });
        Route::get('supplier-payments', [SupplierPaymentsController::class, 'index'])
            ->middleware('role:administrator')
            ->name('admin.bookkeeping.supplier-payments.index');

        Route::prefix('managers-salaries')->group(function () {
            Route::get('/', [ManagersSalariesController::class, 'index'])
                ->name('admin.bookkeeping.managers-salaries.index');

            Route::get('create', [ManagersSalariesController::class, 'create'])
                ->name('admin.bookkeeping.managers-salaries.create');
        });

    });

    Route::group(['middleware' => 'role:administrator', 'prefix' => '/options'], function () {
        Route::get('/', [OptionsController::class, 'index'])->name('admin.options.index');
        Route::get('scripts', [OptionsController::class, 'scripts'])->name('admin.options.scripts');
        Route::resource('colors', ColorsController::class)->names('admin.options.colors');
        Route::post('update/{id}', [OptionsController::class, 'update'])->name('admin.options.update');
        Route::resource('roles', RolesColroller::class)->names('admin.roles');

        Route::prefix('translations')->group(function () {
            Route::get('/', [TranslationsController::class, 'index'])
                ->name('admin.options.translations.index');

            Route::get('create', [TranslationsController::class, 'create'])
                ->name('admin.options.translations.create');
        });

        Route::prefix('advantages')->group(function () {
            Route::get('/', [AdvantagesController::class, 'index'])
                ->name('admin.options.advantages.index');

            Route::get('create', [AdvantagesController::class, 'create'])
                ->name('admin.options.advantages.create');

            Route::get('edit/{id}', [AdvantagesController::class, 'edit'])
                ->name('admin.options.advantages.edit');
        });

        Route::prefix('faq')->group(function () {
            Route::get('/', [FaqController::class, 'index'])
                ->name('admin.options.faq.index');

            Route::get('create', [FaqController::class, 'create'])
                ->name('admin.options.faq.create');

            Route::get('edit/{id}', [FaqController::class, 'edit'])
                ->name('admin.options.faq.edit');
        });
    });

    Route::prefix('users')->middleware('role:administrator')->group(function () {

        Route::get('/', [UsersController::class, 'index'])
            ->name('admin.users.index');

        Route::get('edit/{id}', [UsersController::class, 'edit'])
            ->name('admin.users.edit');

        Route::get('create', [UsersController::class, 'create'])
            ->name('admin.users.create');
    });

    Route::prefix('pages')->middleware('role:administrator')->group(function () {

        Route::get('/', [PagesController::class, 'index'])
            ->name('admin.pages.index');

        Route::get('edit/{id}', [PagesController::class, 'edit'])
            ->name('admin.pages.edit');

        Route::get('create', [PagesController::class, 'create'])
            ->name('admin.pages.create');
    });

    Route::prefix('banners')->group(function () {

        Route::get('/', [BannersController::class, 'index'])
            ->name('admin.banners.index');

        Route::get('create', [BannersController::class, 'create'])
            ->name('admin.banners.create');

        Route::get('edit/{id}', [BannersController::class, 'edit'])
            ->name('admin.banners.edit');
    });

    Route::post('notify-waybill', [\App\Http\Controllers\SmsController::class, 'notifyWaybill'])->name('notifyWaybill');
});
