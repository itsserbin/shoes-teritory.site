<ul class="nav nav-pills">
    @role('administrator')
    <li class="nav-item w-100">
        <a class="nav-link {{ request()->routeIs('admin.bookkeeping.index') ? 'active' : null }}"
           href="{{route('admin.bookkeeping.index')}}"
        >Сводка</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/bookkeeping/costs*') ? 'active' : null }}"
           href="{{route('admin.bookkeeping.costs.index')}}"
        >Расходы</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/bookkeeping/profits*') ? 'active' : null }}"
           aria-current="page"
           href="{{route('admin.bookkeeping.profits.index')}}">Прибыль</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/bookkeeping/orders-statistic*') ? 'active' : null }}"
           aria-current="page"
           href="{{route('admin.bookkeeping.orders-statistic.index')}}">Статистика по заявкам</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/bookkeeping/marketing-statistic*') ? 'active' : null }}"
           aria-current="page"
           href="{{route('admin.bookkeeping.marketing-statistic.index')}}">Маркетинговая статистика</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/bookkeeping/product-statistics*') ? 'active' : null }}"
           aria-current="page"
           href="{{route('admin.bookkeeping.product-statistics.index')}}">Статистика продаж товаров</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/bookkeeping/providers*') ? 'active' : null }}"
           aria-current="page"
           href="{{route('admin.bookkeeping.providers.index')}}">Поставщики</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/bookkeeping/supplier-payments*') ? 'active' : null }}"
           aria-current="page"
           href="{{route('admin.bookkeeping.supplier-payments.index')}}">Выплаты поставщика</a>
    </li>
    @endrole

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/bookkeeping/managers-salaries*') ? 'active' : null }}"
           aria-current="page"
           href="{{route('admin.bookkeeping.managers-salaries.index')}}">Статистика для менеджеров</a>
    </li>
</ul>
