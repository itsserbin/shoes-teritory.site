<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" :href="adminDashboardRoute">
                <img src="/storage/img/content/logo.png" width="75" class="d-inline-block align-top" alt="">
            </a>
            <button class="navbar-toggler" type="button" @click="showDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-between" :class="{'show' : showDropdownMenu}">
                <ul class="navbar-nav">
                    <div v-if="role.administrator || role.manager"
                         class="d-flex"
                         :class="{'flex-column': showDropdownMenu}"
                    >
                        <a class="nav-link"
                           :href="adminDashboardRoute"
                        >Dashboard</a>
                        <a class="nav-link"
                           :href="adminIndexProductsRoute"
                        >Товары</a>
                        <a class="nav-link"
                           :href="adminIndexCategoriesRoute"
                        >Категории</a>
                        <a class="nav-link"
                           :href="adminIndexReviewsRoute"
                        >Отзывы</a>

                        <a v-if="permissions.showClient || permissions.adminPermission"
                           class="nav-link"
                           :href="adminIndexClientsRoute"
                        >Клиенты</a>

                        <a v-if="permissions.showOrders || permissions.adminPermission"
                           class="nav-link"
                           :href="adminIndexOrdersRoute"
                        >Заказы</a>

                        <a v-if="permissions.showBookkeeping || permissions.adminPermission"
                           class="nav-link"
                           :href="adminIndexBookkeepingRoute"
                        >Бухгалтерия</a>
                    </div>

                    <div v-if="role.administrator || role.manager" class="d-flex"
                         :class="{'flex-column': showDropdownMenu}">
                        <a v-if="permissions.editOptions || permissions.adminPermission"
                           class="nav-link"
                           :href="adminIndexOptionsRoute">Настройки</a>
                    </div>

                    <a v-if="permissions.adminPermission"
                       class="nav-link"
                       :href="adminIndexPagesRoute">Страницы</a>


                </ul>
            </div>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           @click="showUserDropdown"
                        >
                            {{ nameUser }}
                        </a>
                        <ul class="dropdown-menu"
                            :class="{'show': showUserDropdownMenu}"
                        >
                            <li class="dropdown-item">
                                <button class="btn" disabled>
                                    <i v-for="role in user.roles"> {{ role.name }}</i>
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="logout" class="dropdown-item">Выйти</button>
                            </li>
                        </ul>
                    </li>
                    <a class="nav-link"
                       :href="homeRoute"
                       target="_blank"
                    >На сайт</a>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            showUserDropdownMenu: false,
            showDropdownMenu: false,
            permissions: {
                showOrders: false,
                showClient: false,
                editOptions: false,
                showBookkeeping: false,
                adminPermission: false,
            },
            role: {
                administrator: false,
                manager: false,
            },
            user: {
                roles: [],
            }
        }
    },
    props: {
        administratorRole: String,
        managerRole: String,
        showClientsPermission: String,
        adminPermission: String,
        showOrdersPermission: String,
        showBookkeepingPermission: String,
        editOptionsPermission: String,

        homeRoute: String,
        adminDashboardRoute: String,
        adminIndexProductsRoute: String,
        adminIndexCategoriesRoute: String,
        adminIndexReviewsRoute: String,
        adminIndexClientsRoute: String,
        adminIndexOrdersRoute: String,
        adminIndexBookkeepingRoute: String,
        adminIndexOptionsRoute: String,
        adminIndexPagesRoute: String,
        adminLogoutRoute: String,

        nameUser: String,
        rolesUser: String,
    },
    created() {
        this.permissions.showOrders = JSON.parse(this.showOrdersPermission);
        this.permissions.showClient = JSON.parse(this.showClientsPermission);
        this.permissions.showBookkeeping = JSON.parse(this.showBookkeepingPermission);
        this.permissions.editOptions = JSON.parse(this.editOptionsPermission);
        this.permissions.adminPermission = JSON.parse(this.adminPermission);
        this.role.administrator = JSON.parse(this.administratorRole);
        this.role.manager = JSON.parse(this.managerRole);
        this.user.roles = JSON.parse(this.rolesUser);
    },
    methods: {
        logout() {
            axios.post(this.adminLogoutRoute)
                .then(() => window.location.href = this.homeRoute)
        },
        showUserDropdown() {
            this.showUserDropdownMenu = !this.showUserDropdownMenu;
        },
        showDropdown() {
            this.showDropdownMenu = !this.showDropdownMenu;
        },
    }
}
</script>
