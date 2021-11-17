<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.index')}}" class="brand-link">
        <img src="{{asset('assets/admin/vendor/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TradingSim</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{$currentUser->image->url??asset('assets/admin/img/empty-image.png')}}"
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('admin.users.edit', $currentUser)}}" class="d-block">{{$currentUser->full_name}}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{route('admin.index')}}" class="nav-link {{Request::is('admin') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item {{Request::is('admin/pages*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/pages*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Pages
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.pages.index')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.pages.index' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All pages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.pages.create')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.pages.create' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create page</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Request::is('admin/users*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/users*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.users.index')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.users.index' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.users.create')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.users.create' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create user</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Request::is('admin/blog*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/blog*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>
                            Blog
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.blogs.index')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.blogs.index' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All blogs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.blogs.create')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.blogs.create' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create blog</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.blog-categories.index')}}"
                               class="nav-link {{Route::is('admin.blog-categories*') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Blog categories</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Request::is('admin/faqs*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/faqs*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-question"></i>
                        <p>
                            FAQs
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.faqs.index')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.faqs.index' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All FAQs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.faqs.create')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.faqs.create' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create FAQ</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Request::is('admin/subscription-plans*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#"
                       class="nav-link {{in_array(Route::currentRouteName(), ['admin.subscription-plans.index', 'admin.subscription-plans.create']) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            Subscription Plans
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.subscription-plans.index')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.subscription-plans.index' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Subscription Plans</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.subscription-plans.create')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.subscription-plans.create' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Subscription Plan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Request::is('admin/promocodes*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/promocodes*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-qrcode"></i>
                        <p>
                            Promo codes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.promocodes.index')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.promocodes.index' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All promo codes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.promocodes.create')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.promocodes.create' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create promo code</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Request::is('admin/orders*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/orders*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Orders
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.orders.index')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.orders.index' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.orders.create')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.orders.create' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create order</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Request::is('admin/taxes*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link {{Request::is('admin/taxes*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Taxes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.taxes.index')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.taxes.index' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All taxes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.taxes.create')}}"
                               class="nav-link {{Route::currentRouteName()=='admin.taxes.create' ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create tax</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{Request::is('admin/subscriptions*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="{{route('admin.subscriptions.index')}}" class="nav-link {{Request::is('admin/subscriptions*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Subscriptions
                        </p>
                    </a>
                </li>
                <li class="nav-item {{Request::is('admin/feedbacks*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="{{route('admin.feedbacks.index')}}" class="nav-link {{Request::is('admin/feedbacks*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Feedbacks
                        </p>
                    </a>
                </li>
                <li class="nav-item {{Request::is('admin/stocks*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="{{route('admin.stocks.index')}}" class="nav-link {{Request::is('admin/stocks*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            Stocks
                        </p>
                    </a>
                </li>
                <li class="nav-item {{Request::is('admin/settings/site*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="{{route('admin.settings.site')}}" class="nav-link {{Request::is('admin/settings/site*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Site setings
                        </p>
                    </a>
                </li>
                <li class="nav-item {{Request::is('admin/settings/payment*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="{{route('admin.settings.payment')}}" class="nav-link {{Request::is('admin/settings/payment*') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-money-check-alt"></i>
                        <p>
                            Payment methods
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                    <form action="{{route('logout')}}" method="post" class="d-none" id="logout-form">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
