<footer class="gs-footer-section {{ $gs->theme == 'theme3' ? 'home-3' : '' }}">
    <div class="container">
        <div class="row footer-row gy-3">
            <div class="col-lg-3 col-md-6 col-12 left-info">
                <img class="logo" src="{{ asset('assets/images/' . $gs->footer_logo) }}" alt="">
                <a class="wow-replaced" data-wow-delay=".1s" href="tel:+11234567890">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                        fill="none">
                        <g clip-path="url(#clip0_241_7633)">
                            <path
                                d="M16 32C24.8366 32 32 24.8366 32 16C32 7.16344 24.8366 0 16 0C7.16344 0 0 7.16344 0 16C0 24.8366 7.16344 32 16 32Z"
                                fill="white" />
                            <path
                                d="M24 19.308C22.274 19.308 20.628 18.932 19.11 18.19C18.872 18.076 18.596 18.058 18.344 18.144C18.092 18.232 17.886 18.416 17.77 18.654L17.05 20.144C14.89 18.904 13.098 17.11 11.856 14.95L13.348 14.23C13.588 14.114 13.77 13.908 13.858 13.656C13.944 13.404 13.928 13.128 13.812 12.89C13.068 11.374 12.692 9.728 12.692 8C12.692 7.448 12.244 7 11.692 7H8C7.448 7 7 7.448 7 8C7 17.374 14.626 25 24 25C24.552 25 25 24.552 25 24V20.308C25 19.756 24.552 19.308 24 19.308Z"
                                fill="#030712" />
                        </g>
                        <defs>
                            <clipPath id="clip0_241_7633">
                                <rect width="32" height="32" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>

                    {{ $ps->phone }}</a>
                <a class="wow-replaced" data-wow-delay=".2s" href="mailto:info@example.com">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                        fill="none">
                        <g clip-path="url(#clip0_241_7638)">
                            <path
                                d="M16 32C24.8366 32 32 24.8366 32 16C32 7.16344 24.8366 0 16 0C7.16344 0 0 7.16344 0 16C0 24.8366 7.16344 32 16 32Z"
                                fill="white" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M25.5214 22.6744C25.6897 22.6742 25.8511 22.6072 25.9701 22.4882C26.0891 22.3692 26.156 22.2078 26.1562 22.0395V10.0484L16.4511 17.7553C16.3228 17.8573 16.1638 17.9129 15.9999 17.9129C15.8361 17.9129 15.677 17.8573 15.5488 17.7553L5.84375 10.0484V22.0395C5.84393 22.2079 5.91087 22.3692 6.02988 22.4882C6.14889 22.6073 6.31025 22.6742 6.47856 22.6744H25.5214ZM24.7327 9.32617L16 16.2609L7.26719 9.32617H24.7327Z"
                                fill="#030712" />
                        </g>
                        <defs>
                            <clipPath id="clip0_241_7638">
                                <rect width="32" height="32" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    {{ $ps->email }}</a>

                <a class="wow-replaced" data-wow-delay=".3s" href="">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                        fill="none">
                        <g clip-path="url(#clip0_241_7643)">
                            <path
                                d="M16 32C24.8366 32 32 24.8366 32 16C32 7.16344 24.8366 0 16 0C7.16344 0 0 7.16344 0 16C0 24.8366 7.16344 32 16 32Z"
                                fill="white" />
                            <path
                                d="M15.9998 7.25C14.1548 7.25 12.3853 7.98295 11.0806 9.28762C9.77592 10.5923 9.04297 12.3618 9.04297 14.2069C9.04297 16.7119 11.9992 21.0594 14.0573 23.7838C14.2847 24.0836 14.5783 24.3268 14.9153 24.4942C15.2523 24.6617 15.6235 24.7488 15.9998 24.7488C16.3761 24.7488 16.7473 24.6617 17.0844 24.4942C17.4214 24.3268 17.715 24.0836 17.9423 23.7838C19.9998 21.0625 22.9567 16.7119 22.9567 14.2069C22.9567 12.3618 22.2238 10.5923 20.9191 9.28762C19.6144 7.98295 17.8449 7.25 15.9998 7.25ZM15.9998 16.1737C15.5107 16.1737 15.0326 16.0287 14.6258 15.757C14.2191 15.4852 13.9022 15.099 13.715 14.647C13.5278 14.1951 13.4788 13.6979 13.5742 13.2181C13.6697 12.7384 13.9052 12.2977 14.2511 11.9519C14.597 11.606 15.0376 11.3704 15.5174 11.275C15.9971 11.1796 16.4944 11.2286 16.9463 11.4158C17.3982 11.6029 17.7844 11.9199 18.0562 12.3266C18.3279 12.7333 18.473 13.2115 18.473 13.7006C18.4728 14.3565 18.2122 14.9854 17.7484 15.4492C17.2847 15.913 16.6557 16.1736 15.9998 16.1737Z"
                                fill="#030712" />
                        </g>
                        <defs>
                            <clipPath id="clip0_241_7643">
                                <rect width="32" height="32" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    {{ $ps->street }}
                </a>

                <div class="social-links">
                    @foreach (DB::table('social_links')->where('user_id', 0)->where('status', 1)->get() as $link)
                        <a class="wow-replaced" data-wow-delay=".3s" href="{{ $link->link }}" target="_blank">
                            <i class="{{ $link->icon }}"></i>
                        </a>
                    @endforeach
                </div>


            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <h5 class="wow-replaced">@lang('Product Category')</h5>
                <ul class="footer-category-links">
                    @foreach ($categories->take(6) as $cate)
                        <li class="wow-replaced" data-wow-delay=".1s"><a
                                href="{{ route('front.category', $cate->slug) }}{{ !empty(request()->input('search')) ? '?search=' . request()->input('search') : '' }}">{{ $cate->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <h5 class="wow-replaced">@lang('Customer Care')</h5>
                <ul class="footer-category-links">


                    @if ($ps->home == 1)
                        <li class="wow-replaced" data-wow-delay=".1s">
                            <a href="{{ route('front.index') }}">{{ __('Home') }}</a>
                        </li>
                    @endif
                    @if ($ps->blog == 1)
                        <li class="wow-replaced" data-wow-delay=".1s">
                            <a href="{{ route('front.blog') }}">{{ __('Blog') }}</a>
                        </li>
                    @endif
                    @if ($ps->faq == 1)
                        <li class="wow-replaced" data-wow-delay=".1s">
                            <a href="{{ route('front.faq') }}">{{ __('Faq') }}</a>
                        </li>
                    @endif
                    @foreach (DB::table('pages')->where('footer', '=', 1)->get() as $data)
                        <li class="wow-replaced" data-wow-delay=".1s"> <a
                                href="{{ route('front.vendor', $data->slug) }}">{{ $data->title }}</a></li>
                    @endforeach
                    @if ($ps->contact == 1)
                        <li class="wow-replaced" data-wow-delay=".1s">
                            <a href="{{ route('front.contact') }}">{{ __('Contact Us') }}</a>
                        </li>
                    @endif


                </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <h5 class=" wow-replaced">@lang('Download Our App')</h5>
                <ul class="footer-category-links">
                    <li class="wow-replaced" data-wow-delay=".1s">
                        <a href="https://play.google.com/store/apps/details?id=com.asmishop.android" target="_blank">
                            <img src="{{ asset('assets/front/images/google_app.png') }}" alt="Google Play Store" width="100%">
                        </a>
                    </li>
                    <li class="wow-replaced" data-wow-delay=".1s">
                        <a href="https://apps.apple.com/app/asmi-shop/id6751156113" target="_blank">
                            <img src="{{ asset('assets/front/images/apple_app.png') }}" alt="Apple App Store" width="100%">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="gs-footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom-content">
                        <p>{{$gs->copyright}} <a href="https://evertechit.com/" target="_blank" style="color: #47e7ff;"> Developed By Evertech IT</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
