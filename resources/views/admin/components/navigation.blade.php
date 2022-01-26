<admin-header
    administrator-role="{{json_encode(auth()->check() && auth()->user()->hasRole('administrator'))}}"
    manager-role="{{json_encode(auth()->check() && auth()->user()->hasRole('manager'))}}"
    show-clients-permission="{{json_encode(Gate::allows('show-clients'))}}"
    admin-permission="{{json_encode(Gate::allows('admin'))}}"
    show-orders-permission="{{json_encode(Gate::allows('show-orders'))}}"
    show-bookkeeping-permission="{{json_encode(Gate::allows('show-bookkeeping'))}}"
    edit-options-permission="{{json_encode(Gate::allows('edit-options'))}}"

    home-route="{{route('home')}}"
    admin-dashboard-route="{{route('admin.dashboard')}}"
    admin-index-products-route="{{route('admin.products.index')}}"
    admin-index-categories-route="{{route('admin.categories.index')}}"
    admin-index-reviews-route="{{route('admin.reviews.index')}}"
    admin-index-clients-route="{{route('admin.clients.index')}}"
    admin-index-orders-route="{{route('admin.orders.index')}}"
    admin-index-bookkeeping-route="{{route('admin.bookkeeping.index')}}"
    admin-index-options-route="{{route('admin.options.index')}}"
    admin-index-promo-codes-route="{{route('admin.promo-codes.index')}}"
    admin-logout-route="{{route('logout')}}"

    name-user="{{auth()->user()->name}}"
    roles-user="{{json_encode(auth()->user()->roles)}}"
></admin-header>
