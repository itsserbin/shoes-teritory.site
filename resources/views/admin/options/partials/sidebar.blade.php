<ul class="nav nav-pills">
    <li class="nav-item w-100">
        <a class="nav-link {{ request()->routeIs('admin.options.index') ? 'active' : null }}" aria-current="page"
           href="{{route('admin.options.index')}}">Основные</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/options/scripts*') ? 'active' : null }}" aria-current="page"
           href="{{route('admin.options.scripts')}}">Скрипты</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/options/colors*') ? 'active' : null }}" aria-current="page"
           href="{{route('admin.options.colors.index')}}">Цвета товара</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : null }}" aria-current="page"
           href="{{route('admin.users.index')}}">Пользователи</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/options/roles*') ? 'active' : null }}" aria-current="page"
           href="{{route('admin.roles.index')}}">Роли</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/banners*') ? 'active' : null }}" aria-current="page"
           href="{{route('admin.banners.index')}}">Баннера</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/options/translations*') ? 'active' : null }}" aria-current="page"
           href="{{route('admin.options.translations.index')}}">Переводы</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/options/advantages*') ? 'active' : null }}"
           href="{{route('admin.options.advantages.index')}}"
        >Настройка преимуществ</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/options/faq*') ? 'active' : null }}"
           href="{{route('admin.options.faq.index')}}"
        >Настройка FAQ</a>
    </li>

    <li class="nav-item w-100">
        <a class="nav-link {{ request()->is('admin/promo-codes*') ? 'active' : null }}"
           href="{{route('admin.promo-codes.index')}}"
        >Промо коды</a>
    </li>
</ul>
