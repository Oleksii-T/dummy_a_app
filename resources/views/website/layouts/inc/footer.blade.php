<a href="" class="scroll_to_top"></a>
<footer class="footer">
    <div class="container fooret__container">
        <div class="fooret__body">
            <div class="footer__top">
                <div class="footer__top-left">
                    <a href="{{route('website.index')}}" class="footer__logo logo">
                        <img src="{{asset('assets/website/img/logo-blue.svg')}}" alt="">
                    </a>
                    <span class="footer__slogan">
                        TITLE
                    </span>
                </div>
                <div class="footer__top-right">
                    <nav class="footer__menu">
                        <div class="footer__menu-item">
                            <h4 class="footer__menu-title">Product</h4>
                            <ul class="footer__menu-list">
                                <li>
                                    <a href="{{route('website.how-it-works')}}">How it works</a>
                                </li>
                                <li>
                                    <a href="{{route('website.subscription-plans.index')}}">Pricing</a>
                                </li>
                                <li>
                                    <a href="{{route('website.faq.index')}}">FAQ</a>
                                </li>
                            </ul>
                        </div>
                        <div class="footer__menu-item">
                            <h4 class="footer__menu-title">Company</h4>
                            <ul class="footer__menu-list">
                                <li>
                                    <a href="{{route('website.about')}}">About Us</a>
                                </li>
                                <li>
                                    <a href="{{route('website.blogs.index')}}">Blog</a>
                                </li>
                                <li>
                                    <a href="{{route('website.blogs.index')}}">Join</a>
                                </li>
                            </ul>
                        </div>
                        <div class="footer__menu-item">
                            <h4 class="footer__menu-title">Contact Us</h4>
                            <ul class="footer__menu-list">
                                <li>
                                    <a href="#">exaplpe@example.com</a>
                                </li>
                                <li>
                                    <a href="#">ADDRESS</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="footer__bottom">
                <p class="footer__bottom-privaci">© 2021 Company Name Ltd. All rights reserved.</p>
                <div class="footer__bottom-right">
                    <div class="footer__bottom-links">
                        <a href="{{route('website.terms')}}">Terms</a>
                        <a href="{{route('website.privacy')}}">Privacy</a>
                        <a href="{{route('website.refunds')}}">Refunds</a>
                    </div>
                    <div class="footer__bottom-social">
                        @if (\App\Models\Setting::get('twitter'))
                            <a href="{{\App\Models\Setting::get('twitter')}}" target="_blank"><img src="{{asset('assets/website/img/social-1.svg')}}" alt=""></a>
                        @endif
                        @if (\App\Models\Setting::get('facebook'))
                            <a href="{{\App\Models\Setting::get('facebook')}}" target="_blank"><img src="{{asset('assets/website/img/social-2.svg')}}" alt=""></a>
                        @endif
                        @if (\App\Models\Setting::get('youtube'))
                            <a href="{{\App\Models\Setting::get('youtube')}}" target="_blank"><img src="{{asset('assets/website/img/social-3.svg')}}" alt=""></a>
                        @endif
                        @if (\App\Models\Setting::get('instagram'))
                            <a href="{{\App\Models\Setting::get('instagram')}}" target="_blank"><img src="{{asset('assets/website/img/social-4.svg')}}" alt=""></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
@include('website.layouts.inc.footer-popup')
