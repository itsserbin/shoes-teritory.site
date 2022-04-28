<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

/** Admin panel */
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Категории', route('admin.categories.index'));
});

Breadcrumbs::for('categories.create', function ($trail) {
    $trail->parent('categories');
    $trail->push('Добавление категории', route('admin.categories.create'));
});

Breadcrumbs::for('categories.edit', function ($trail) {
    $trail->parent('categories');
    $trail->push('Редактирование категории');
});

Breadcrumbs::for('bookkeeping', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Бухгалтерия', route('admin.bookkeeping.index'));
});

Breadcrumbs::for('pages', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Страницы', route('admin.pages.index'));
});

Breadcrumbs::for('pages.create', function ($trail) {
    $trail->parent('pages');
    $trail->push('Добавление страницы', route('admin.pages.create'));
});

Breadcrumbs::for('pages.edit', function ($trail) {
    $trail->parent('pages');
    $trail->push('Редактирование страницы');
});

Breadcrumbs::for('products', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Товары', route('admin.products.index'));
});

Breadcrumbs::for('products.edit', function ($trail) {
    $trail->parent('products');
    $trail->push('Редактирование товара');
});

Breadcrumbs::for('products.create', function ($trail) {
    $trail->parent('products');
    $trail->push('Создание товара');
});

Breadcrumbs::for('options', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Настройки', route('admin.options.index'));
});

Breadcrumbs::for('options.promo-codes', function ($trail) {
    $trail->parent('options');
    $trail->push('Промо-коды', route('admin.promo-codes.index'));
});

Breadcrumbs::for('options.promo-codes.create', function ($trail) {
    $trail->parent('options.promo-codes');
    $trail->push('Добавление промо-кода', route('admin.promo-codes.create'));
});

Breadcrumbs::for('options.promo-codes.edit', function ($trail) {
    $trail->parent('options.promo-codes');
    $trail->push('Редактирование промо-кода');
});

Breadcrumbs::for('options.faq', function ($trail) {
    $trail->parent('options');
    $trail->push('Настройка FAQ', route('admin.options.faq.index'));
});

Breadcrumbs::for('options.faq.create', function ($trail) {
    $trail->parent('options.faq');
    $trail->push('Добавление FAQ', route('admin.options.faq.create'));
});

Breadcrumbs::for('options.faq.edit', function ($trail) {
    $trail->parent('options.faq');
    $trail->push('Редактирование FAQ');
});

Breadcrumbs::for('options.advantages', function ($trail) {
    $trail->parent('options');
    $trail->push('Настройка преимуществ', route('admin.options.advantages.index'));
});

Breadcrumbs::for('options.advantages.create', function ($trail) {
    $trail->parent('options.advantages');
    $trail->push('Добавление преимущества', route('admin.options.advantages.create'));
});

Breadcrumbs::for('options.advantages.edit', function ($trail) {
    $trail->parent('options.advantages');
    $trail->push('Редактирование преимущества');
});

Breadcrumbs::for('options.translations', function ($trail) {
    $trail->parent('options');
    $trail->push('Переводы', route('admin.options.translations.index'));
});

Breadcrumbs::for('options.translations.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Добавить перевод', route('admin.options.translations.create'));
});

Breadcrumbs::for('options.banners', function ($trail) {
    $trail->parent('options');
    $trail->push('Баннера', route('admin.banners.index'));
});

Breadcrumbs::for('options.banners.edit', function ($trail) {
    $trail->parent('options.banners');
    $trail->push('Редактирование баннера');
});

Breadcrumbs::for('options.banners.create', function ($trail) {
    $trail->parent('options.banners');
    $trail->push('Создание баннера');
});

Breadcrumbs::for('bookkeeping.marketing-statistic', function ($trail) {
    $trail->parent('bookkeeping');
    $trail->push('Статистика по заявкам', route('admin.bookkeeping.marketing-statistic.index'));
});

Breadcrumbs::for('bookkeeping.orders-statistic', function ($trail) {
    $trail->parent('bookkeeping');
    $trail->push('Статистика по заявкам', route('admin.bookkeeping.orders-statistic.index'));
});

Breadcrumbs::for('bookkeeping.providers', function ($trail) {
    $trail->parent('bookkeeping');
    $trail->push('Поставщики', route('admin.bookkeeping.providers.index'));
});

Breadcrumbs::for('bookkeeping.providers.create', function ($trail) {
    $trail->parent('bookkeeping.providers');
    $trail->push('Добавление поставщика', route('admin.bookkeeping.providers.create'));
});

Breadcrumbs::for('bookkeeping.providers.edit', function ($trail) {
    $trail->parent('bookkeeping.providers');
    $trail->push('Редактирование поставщика');
});

Breadcrumbs::for('bookkeeping.costs', function ($trail) {
    $trail->parent('bookkeeping');
    $trail->push('Расходы', route('admin.bookkeeping.costs.index'));
});

Breadcrumbs::for('bookkeeping.costs.edit', function ($trail) {
    $trail->parent('bookkeeping.costs');
    $trail->push('Редактирование расхода');
});

Breadcrumbs::for('bookkeeping.costs.create', function ($trail) {
    $trail->parent('bookkeeping.costs');
    $trail->push('Добавление расхода');
});

Breadcrumbs::for('bookkeeping.costs.categories', function ($trail) {
    $trail->parent('bookkeeping.costs');
    $trail->push('Категории расходов', route('admin.bookkeeping.costs.categories.index'));
});

Breadcrumbs::for('bookkeeping.costs.categories.create', function ($trail) {
    $trail->parent('bookkeeping.costs.categories');
    $trail->push('Создание', route('admin.bookkeeping.costs.categories.create'));
});

Breadcrumbs::for('bookkeeping.costs.categories.edit', function ($trail) {
    $trail->parent('bookkeeping.costs.categories');
    $trail->push('Редактирование');
});
