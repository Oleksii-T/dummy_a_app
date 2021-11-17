<header class="header {{request()->routeIs('website.index') ? '' : 'not-home'}}">
    <div class="container header__container">
        <div class="header__body">
            <a href="{{route('website.index')}}" class="header__logo logo">
                <img src="{{\App\Models\Setting::get('site_logo')->url??asset('assets/website/img/logo.svg')}}" alt="LGOO">
            </a>
            <nav class="header__menu menu">
                <ul class="menu__list">
                    <li>
                        <a href="{{route('website.features')}}">
                            Features
                        </a>
                    </li>
                    <li>
                        <a href="{{route('website.about')}}">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{route('website.how-it-works')}}">
                            How It Works
                        </a>
                    </li>
                    <li>
                        <a href="{{route('website.blogs.index')}}">
                            Blog
                        </a>
                    </li>
                    <li>
                        <a href="{{route('website.faq.index')}}">
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="{{route('website.subscription-plans.index')}}">
                            Pricing
                        </a>
                    </li>
                    <li>
                        <a href="{{route('website.contact-us.index')}}">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="buttons-group">
                @auth
                    <a href="{{route('website.profile')}}" class="btn btn-sm btn-blue">
                        Account
                    </a>
                    <form action="{{route('logout')}}" method="post" id="logout-form">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-white">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{route('website.login')}}" class="btn btn-sm btn-white">
                        Log In
                    </a>
                @endauth
            </div>
            <div class="header__burger">
                <span></span>
            </div>
        </div>
    </div>
</header>
