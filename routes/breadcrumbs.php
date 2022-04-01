<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('bookkeeping', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Бухгалтерия', route('admin.bookkeeping.index'));
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
