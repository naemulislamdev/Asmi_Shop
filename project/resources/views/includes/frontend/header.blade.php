<header class="header">
     {{-- App Download Banner --}}
    <div class="d-block d-lg-none ">
        <a target="_blank" href="https://play.google.com/store/apps/details?id=com.asmishop.android"
            class="d-flex align-items-center justify-content-center py-1 gap-1 px-1" style="background: #FFF9C4;">
            <img src="{{ asset('assets/front/images/app-download.png') }}" alt="Asmishop"
                style="width:100px; height:36px; object-fit:contain;">
            <span class="fw-800" style="font-size:14px; color:#222; font-weight: 700;">Asmishop App</span>
            <button class="d-flex align-items-center gap-1 text-white rounded-pill px-2 py-1"
                style="background:#005862; font-size:11px; font-weight:500; text-decoration:none;">
                Download Now <i class="fa fa-chevron-right" style="font-size:11px;"></i>
            </button>
        </a>
    </div>
    {{-- App Download Banner End --}}
    <div class="container-fluid pt-1">
        <!-- Desktop Logo, Menubar, Search Start -->
        <div class="d-flex align-items-center justify-content-between px-1 px-lg-3 gap-2 gap-lg-3"
            style="flex-wrap: nowrap; min-width: 0;">

            {{-- Logo + WhatsApp + Offers (left group) --}}
            <div class="d-flex align-items-center gap-2 gap-lg-4 flex-shrink-0 logosRow" style="min-width: 0;">
                <div class="menu-icon active d-none d-lg-block menu-btn">
                    <i class="fa-solid fa-bars-staggered barIcon"></i>
                </div>
                <a href="{{ route('front.index') }}" class="flex-shrink-0">
                    <img src="{{ asset('assets/images/' . $gs->logo) }}" class="logo" alt="Asmishop" />
                </a>
                <div class="whatsapp_div d-none d-lg-block flex-shrink-0">
                    <div class="d-flex align-items-center gap-2">
                        <img style="width: 36px; height: auto;" src="{{ asset('assets/front/images/whatsapp.png') }}"
                            alt="whatsapp">
                        <div>
                            <a href="https://wa.me/8801805020340?text=Assalamu%20Alaikum,%20I%20want%20to%20order%20from%20your%20supershop."
                                class="text-success fw-bold d-block" style="font-size: 13px; white-space: nowrap;">
                                01805020340
                            </a>
                            <a class="text-success fw-bold d-block" style="font-size: 13px; white-space: nowrap;"
                                href="https://wa.me/8801805020346?text=Assalamu%20Alaikum,%20I%20want%20to%20order%20from%20your%20supershop.">01805020346</a>
                        </div>
                    </div>
                </div>

                {{-- Mobile: WhatsApp icon --}}
                <a class="d-block d-lg-none flex-shrink-0" target="_blank"
                    href="https://wa.me/8801805020340?text=Assalamu%20Alaikum,%20I%20want%20to%20order%20from%20your%20supershop.">
                    <img style="width: 36px; height: auto;" src="{{ asset('assets/front/images/whatsapp.png') }}"
                        alt="whatsapp">
                </a>

                {{-- Mobile: Offers link --}}
                <div class="d-block d-lg-none flex-shrink-0">
                    <a href="{{ route('front.offers') }}" class="d-flex gap-1 align-items-center">

                        <img style="width: 50px; height: auto;" src="{{ asset('assets/front/images/offer.gif') }}"
                            alt="best offer">
                    </a>
                </div>
            </div>

            {{-- Desktop Search Box (center, fills remaining space) --}}
            <div class="search-box d-none d-lg-flex position-relative flex-grow-1"
                style="min-width: 0; max-width: 480px;">
                <form action="{{ route('front.search') }}" method="GET" style="width: 100%;">
                    <input autocomplete="off" type="text" name="search" class="searchInput form-control"
                        placeholder="Search for Products (e.g. " style="width: 100%;" />
                    <div class="typing-placeholder">
                        <span class="typingText"></span>)
                    </div>
                </form>
                <div class="searchResults"
                    style="min-height: 0; max-height: 300px; overflow-y: auto; overflow-x: hidden;
                           background: #fff; border-radius: 4px; position: absolute;
                           top: 100%; left: 0; width: 100%; z-index: 9999;">
                </div>
            </div>

            {{-- Download App Image (desktop only) --}}
            <div class="d-none d-lg-block flex-shrink-0">
                <a href="https://play.google.com/store/apps/details?id=com.asmishop.android" target="_blank">
                    <img style="width: 130px; height: auto;" class="img-fluid"
                        src="{{ asset('assets/front/images/download_last.png') }}" alt="download app">
                </a>
            </div>

            {{-- Login Button (desktop only) --}}
            <div class="d-none d-lg-block flex-shrink-0">
                @if (Auth::guard('web')->check())
                    <a class="btn btn-sm login-btn" href="{{ route('user-dashboard') }}">
                        <i class="fa fa-user-circle" aria-hidden="true"></i> @lang('Dashboard')
                    </a>
                @else
                    <a href="{{ route('user.login') }}" class="btn btn-sm login-btn">
                        <i class="fa fa-sign-in" aria-hidden="true"></i> @lang('Login')
                    </a>
                @endif
            </div>

            {{-- Notification Bell --}}
            <div class="flex-shrink-0 conditonalNotification">
                <div class="dropdown position-relative">
                    @php $offers = session('offers', []); @endphp
                    <button class="btn p-0 border-0 bg-transparent dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                        <img style="height: 30px; width: auto;"
                            src="{{ asset('assets/front/images/notification.gif') }}" alt="Notification Bell">
                        <span style="top: 0; left: 22px;"
                            class="position-absolute translate-middle badge rounded-pill bg-primary">
                            {{ count($offers) }}
                        </span>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow pt-0" style="min-width: 220px;">
                        @if (count($offers) > 0)
                            <div class="offer-header rounded-top">
                                <span>🎁 Special Offer Unlocked</span>
                            </div>
                        @endif
                        @forelse($offers as $offer)
                            <li class="mb-3 d-inline-block">
                                <a class="dropdown-item"
                                    href="{{ route('front.conditional-product', $offer['sku']) }}">
                                    <img style="width: 40px;" src="{{ $offer['image'] }}" alt="{{ $offer['name'] }}">
                                    <span>{{ $offer['name'] }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-center p-2">No Offers found in your cart!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <!-- Desktop Logo, Menubar, Search End -->

        {{-- Mobile Search Box --}}
        <!-- <div class="search-box d-block d-lg-none position-relative px-2 pb-2">
            <form action="{{ route('front.search') }}" method="GET">
                <input autocomplete="off" type="text" name="search" class="searchInput form-control"
                    placeholder="Search for Products (e.g. " style="width: 100%;" />
                <div class="typing-placeholder">
                    <span class="typingText"></span>)
                </div>
            </form>
            <div class="searchResults"
                style="min-height: 0; max-height: 300px; overflow-y: auto; overflow-x: hidden;
                       background: #fff; border-radius: 4px; position: absolute;
                       top: 100%; left: 8px; right: 8px; z-index: 9999;">
            </div>
        </div> -->
    </div>
</header>
