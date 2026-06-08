<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="https://asmishop.com/">
     
    <!--Essential css files-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/slick.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/nice-select.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/animate.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/datatables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/custom.css">

    <link rel="icon" href="{{ asset('assets/images/' . $gs->favicon) }}">
    @include('includes.frontend.extra_head')
    <meta name="keywords"
        content="online grocery shop, bangladesh grocery online, bd online shop list, online shop list in bangladesh, daily shopping mohammadpur, bangladesh online grocery, online grocery shop bd, online grocery shops in bangladesh, daily shopping online, grocery store dhaka, daily online shopping, best online grocery shop in dhaka, grocery store online, online grocery shop dhaka, online grocery shopping, top online shop in bd, online super shop, grocery items list in bangladesh, groceries store, daily shopping, grocery shop, bangladesh online shopping website list, grocery shop bd, top 10 online shopping sites in bangladesh, best online shopping sites in bangladesh, daily shopping bangladesh, daily shopping bd, bangladesh best online shopping site, best online shopping website in bangladesh, grocery shop online, online grocery, bangladesh grocery store, grocery shop in bangladesh, grocery shopping, best supershop in dhaka">
    @yield('css')
    <style>
        .header-top {
            padding: 15px 0;
        }

        .fa-whatsapp {
            color: #048835;
            background: #fff;
            padding: 3px 6px;
            font-size: 22px;
            border-radius: 7px;
        }

        .header-logo-wrapper>img {
            width: 142px;
        }

        .single-product .content-wrapper,
        .single-product-list-view .content-wrapper {
            height: auto;
            background: #ffff;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 14px 13px !important;

        }

        .gs-breadcrumb-section {
            padding: 80px 0px;
            position: relative;
        }

        .gs-breadcrumb-section::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 0%;
            background-color: rgba(15, 42, 66, 0.5);
            z-index: 1;
        }

        .gs-hero-section {
            height: 400px;
        }

        .gs-cate-section {
            padding: 35px 0px;
        }

        .gs-offer-section .product-wrapper {
            border-radius: 20px;
            background: #ddd;
            overflow: hidden;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .gs-explore-product-section {
            padding: 0px;
        }

        .gs-offer-section {
            padding-bottom: 52px;
        }

        .gs-footer-section .footer-row {
            padding-top: 30px;
            padding-bottom: 0px;
        }

        .gs-footer-section {
            background-color: #005862;
        }

        .gs-footer-section .gs-footer-bottom {
            background-color: #007182;
        }

        .gs-single-cat {
            background: #ffffff;
            border-radius: 12px;
        }

        .gs-single-cat .cate-img {
            width: 190px;
            height: 190px;
            border: 0px solid #858585;
            border-radius: 0;
            margin-bottom: 4px;
        }

        .gs-single-cat .title {
            margin-bottom: 4px;
            color: #fff;
            font-size: 18px;
        }

        .single-product .add-cart,
        .single-product-list-view .add-cart {
            width: 110px;
        }

        .single-product .add-to-cart,
        .single-product-list-view .add-to-cart {
            gap: 5px;
        }

        .measure-product {
            color: #888888 !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            margin-top: 5px;
        }

       

             /* for discount box*/
        .single-product .discount-box span {
            position: relative;
            display: inline-block;
            background: #e60023;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 8px;
            text-align: center;
            font-family: "Rubik", sans-serif;
            z-index: 999;
            
        }
        .flash_timer {
            background: #fff12e;
            border: 2px solid #ff9800;
            border-radius: 8px;
            padding: 5px 5px;
            min-width: 80px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 11px;
        }
        
        @media (min-width: 0px) and (max-width: 600px) {
           .single-product .discount-box span::after {
                bottom: -3px;
                height: 3px;
                background-size: 7px 7px;
            }
            .flash_timer {
            font-size: 10px;
        }
        }
   

        .single-product .discount-box span small {
            display: block;
            font-size: 11px;
        }

        /* zigzag bottom */
        .discount-box span::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -7px;
            width: 100%;
            height: 14px;
            background:
                linear-gradient(-45deg, transparent 75%, #e60023 75%) 0 0,
                linear-gradient(45deg, transparent 75%, #e60023 75%) 0 0;
            background-size: 7px 7px;
        }
        .single-product {
            height: 100% !important;
            width: 100%;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: left !important;

        }
      .row {
            align-items: stretch;
        }
      
        /* from ai */
        .outofstock-box {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .outofstock-box h5 {
            color: #fff;
            font-size: 16px;
            background: #eb4d4b;
            padding: 5px 10px;
            border-radius: 5px;
        }


        .single-product {
            border: 1px solid #ddd;
      
        }

        * .container {
            padding: 0 20px !important;
        }
    
       .searchResults::-webkit-scrollbar {
   			 width: 3px;
		}
		.searchResults::-webkit-scrollbar-thumb {
    		background: #1598a7;
    		border-radius: 10px;
		}
        .gs-partner-section .single-partner img {
    	object-fit: contain;
	}
    .single-product .img-wrapper {
    	background: #fff;
      
    }
      .mobile-offcanvas button:not(.collapsed) i.fa-plus {
    display: none;
}
.mobile-offcanvas button:not(.collapsed) i.fa-minus {
    display: inline-block;
}
.product-cat-widget {
    padding-top: 24px;
    padding-bottom: 90px !important;
}

.gs-single-cat:hover .title {
    color: #fff;
}
.gs-single-cat .title {
    font-size: 16px !important;
}
.gs-single-cat .cate-img {
    object-fit: contain;
    max-width: 100%;
    height: auto;
}
.home-cate-slider .slick-slide {
  margin: 0 10px; /* total gap = 20px */
}

.home-cate-slider .slick-list {
  margin: 0 -10px;
}
.col-lg-2 {
    padding: 0 4px !important;
}
 .whatsapp_div {
            position: static;
        }

        @media (max-width: 768px) {
            .whatsapp_div {
                position: relative;
                left: -30px;
            }
        }
		.outofstock-box-2 {
 			background: rgba(0, 0, 0, 0.6) !important;
		}
		  @media (max-width: 768px) {
            .gs-partner-section .col-xl-2 {
                flex: 0 0 auto;
                width: 33% !important;
            }
          .single-product .img-wrapper, .single-product-list-view .img-wrapper {
                overflow: hidden;
                position: relative;
                /* height: 180px !important; */
            }
           

            .single-product .img-wrapper a {
                display: block;
                height: 100%;
                width: 100%;

            }

            .single-product .img-wrapper .product-img,
            .single-product-list-view .img-wrapper .product-img {
                width: 100%;
                object-fit: contain;
            }
             .single-product .content-wrapper a {
            font-size: 13px !important;
        }
            
        }
		.mobile-offcanvas {
 		 	height: calc(100vh - 70px) !important;
  			padding-bottom: 100px !important;
  			margin-bottom: 100px important;
  			overflow-y: auto;
		}
        .slick-slider {
            margin-bottom: 25px;
        }
        .single-product .content-wrapper a {
            color: #111;
            font-size: 15px;
        }
        .single-product .content-wrapper a:hover {
            color: #1598a7;
        }
         @media (max-width: 768px) {
            .product-colum {
                padding: 0 9px !important;
            }
            .row.gy-2 {
                --bs-gutter-y: 15px !important;
            }
        }
        .gs-explore-product-section {
            padding-bottom: 20px;
        }
        @media (min-width: 992px) {
           .swiper.home-category-slider {
                height: 222px;
            }
            .single-product .img-wrapper {
                height: 200px;
            }
        }
       
 
		   /*  For search placheloder animation*/

        .search-box {
            position: relative;
        }

        .typing-placeholder {
            position: absolute;
            left: 192px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #1598a7;
            font-size: 14px;
            white-space: nowrap;
        }

        /* cursor effect */
        .typingText::after {
            content: "|";
            margin-left: 2px;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        .search-box input {
            border-color: #1598a7 !important;
        }

        .search-box input::placeholder {
            color: #1598a7;
        }
        .mobile-category-box{
            padding: 0 11px; 
            margin-bottom: 11px;
        }
        @media (max-width: 768px) {
           .typing-placeholder {
                left: 203px;
            }
            .search-box.d-lg-none {
                padding: 0 !important;
            }
            .category-item img {
                object-fit: cover !important;
            }
            .mobile-category-box{
            padding: 0 5px !important; 
           
        }
        .countdown-box .time-box {
            min-width: 60px;
        }
        .add-cart-btn.btn-info {
            padding: 3px 5px;
        }
        .offer-popup {
            top: 120px !important;
        }
    }
    .searchResults {
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }
    </style>
    <style>
        .offer-popup {
            position: fixed;
            top: 70px;
            right: 20px;
            width: 340px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            overflow: hidden;
            transform: translateX(120%);
            transition: all 0.4s ease;
        }

        .offer-popup.show {
            transform: translateX(0);
        }

        .offer-header {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff;
            padding: 12px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

       .offer-header button {
            font-size: 17px;
            cursor: pointer;
        }

        .offer-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .offer-item {
            display: flex;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .offer-item img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .offer-info {
            flex: 1;
        }

        .offer-title {
            font-size: 14px;
            font-weight: 600;
        }

        .offer-price {
            color: #28a745;
            font-weight: bold;
        }

        .offer-btn {
            background: #ff5722;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
        }

        .offer-btn:hover {
            background: #e64a19;
        }
    </style>
    <style>
 /* ✅ Toastr Global */
#toast-container > div {
    background-position: 15px center !important;
    background-size: 20px !important;
    padding: 12px 12px 12px 50px !important;
    border-radius: 8px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
    opacity: 1 !important;
    min-width: 250px !important;
}

#toast-container .toast-close-button {
    color: #fff !important;
    font-size: 16px !important;
}

#toast-container .toast-progress {
    opacity: 0.4 !important;
}

/* ✅ Success */
#toast-container .toast-success {
    background-color: #27ae60 !important;
    color: #fff !important;
}

#toast-container .toast-success .toast-message,
#toast-container .toast-success .toast-title {
    color: #fff !important;
}

/* ⚠️ Warning */
#toast-container .toast-warning {
    background-color: #f39c12 !important;
    color: #fff !important;
}

#toast-container .toast-warning .toast-message,
#toast-container .toast-warning .toast-title {
    color: #fff !important;
}

/* ❌ Error */
#toast-container .toast-error {
    background-color: #e74c3c !important;
    color: #fff !important;
}

#toast-container .toast-error .toast-message,
#toast-container .toast-error .toast-title {
    color: #fff !important;
}

/* ℹ️ Info */
#toast-container .toast-info {
    background-color: #2980b9 !important;
    color: #fff !important;
}

#toast-container .toast-info .toast-message,
#toast-container .toast-info .toast-title {
    color: #fff !important;
}
    .qty-btn.disabled {
    opacity: 0.4;
    pointer-events: none;
}
 .offer-info-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .offer-info-row:last-child {
            border-bottom: none;
        }

        .offer-info-icon {
            font-size: 1.8rem;
        }

        .offer-amount {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.1rem;
        }
</style>

<style>
    .card-timer-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(0, 0, 0, 0.75);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 6px;
}

.cd-unit {
    display: flex;
    flex-direction: column;
    align-items: center;
    line-height: 1.1;
}

.cd-unit span {
    font-size: 13px;
    font-weight: 700;
}

.cd-unit small {
    font-size: 8px;       /* label খুব ছোট */
    font-weight: 400;
    color: #ccc;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.cd-sep {
    color: #f59e0b;
    font-size: 13px;
    margin-bottom: 8px;   /* separator উপরে রাখতে */
}
@media (min-width: 992px) {
    .heroSlider {
        height: 47vh;
        max-height: 47vh;
    }
}

@media (max-width: 991px) {
    .heroSlider {
        height: 15vh;
        max-height: 15vh;
    }
}

.heroSlider .swiper-slide {
    height: 100%;
}

.heroSlider .swiper-slide a {
    display: block;
    width: 100%;
    height: 100%;
}

.heroSlider .swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: fill;     
  
    display: block;
}
@media (max-width: 768px) {
    .cate-title h6 {
    font-size: 13px;
}
}
</style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/sidebar.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/customize.css">
    <!-- Meta Pixel Code -->

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NGVKWTDQ');</script>
<!-- End Google Tag Manager -->
</head>

<body class="overflow-auto" style="overflow: auto !important;">
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NGVKWTDQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ $seo->facebook_pixel }}&ev=PageView&noscript=1" />
</noscript>

    @php
        $categories = App\Models\Category::with('subs')->where('status', 1)->get();
        $pages = App\Models\Page::get();
        $currencies = App\Models\Currency::all();
        $languges = App\Models\Language::all();
    @endphp
    <!-- header area -->
    @include('includes.frontend.header') 
   

    <!-- Desktop Sidebar Start -->
    <aside id="sidebar" class="sidebar active pt-4 shadow">

        <!-- Offers Section -->
        <div class="offers-container">
    		   @foreach ($categories as $category)
                @if ($category->name == 'Family Pack')
                    <a style="font-size: 15px; color: #1598a7" href="{{ route('front.category', $category->slug) }}">

                        {{ $category->name }}
                        <img class="rounded ms-3" style="width: 50px"
                            src="{{ asset('assets/images/categories') }}/{{ $category->image }}" alt="{{ $category->name }}">
                    </a>
                @endif
            @endforeach
            <a href="{{ route('front.offers') }}" class="d-flex gap-2 align-items-center mb-2 ">
                <p style="font-size: 15px; color: #1598a7" class="pb-0 mb-0 d-flex">
                    Offers
                    <span class="offer-outline-btn ms-3">
                        {{ App\Models\Product::where('discount', '>', 0)->count() }}
                    </span>
                    
                </p>
                    <img class="ms-3" style="width: 100px; height: auto;"
                        src="{{ asset('assets/front/images/offer.gif') }}" alt="best offer">
            </a>
            {{-- <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0">Egg Club</p>
            </a> --}}
        </div>

        {{-- <div class="ps-3">
            <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0"><img src="{{ asset('assets/assets/images/icons/favourites.svg') }}" /> Favourites
                </p>
            </a>
            <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0"><img src="{{ asset('assets/assets/images/icons/winter-collection.webp') }}" />
                    Winter Collection</p>
            </a>
            <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0"><img src="{{ asset('assets/assets/images/icons/flash-sales.webp') }}" /> Flash
                    Sales</p>
            </a>
        </div> --}}

        <!-- MAIN ACCORDION -->
        <div class="product-cat-widget">
            <ul class="accordion">
                @foreach ($categories as $category)
                    @php
                        $isCategoryActive = Request::segment(2) === $category->slug;
                        $catId = 'cat_' . $category->slug . '_level_2';
                    @endphp

                    <li>
                        @if ($category->subs->count() > 0)
                            <div class="d-flex justify-content-between align-items-lg-baseline">
                                <a  style="font-size: 16px;" href="{{ route('front.category', $category->slug) }}"
                                    class="{{ $isCategoryActive ? 'sidebar-active-color' : '' }}"
                                    data-collapse="#{{ $catId }}">
                                   <img class="rounded me-1" style="width: 30px" src="{{asset('assets/images/categories')}}/{{$category->image}}" alt=""> {{ $category->name }}
                                </a>

                                <button type="button" data-bs-toggle="collapse" data-bs-target="#{{ $catId }}"
                                    aria-expanded="{{ $isCategoryActive ? 'true' : 'false' }}"
                                    class="{{ $isCategoryActive ? '' : 'collapsed' }}">
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                            </div>

                            <ul id="{{ $catId }}"
                                class="accordion-collapse collapse ms-3 mt-2 {{ $isCategoryActive ? 'show' : '' }}">

                                @foreach ($category->subs as $subcategory)
                                    @php
                                        $isSubActive = $isCategoryActive && Request::segment(3) === $subcategory->slug;
                                        $subId = 'sub_' . $subcategory->slug . '_lvl2';
                                    @endphp

                                    <li>
                                        <div class="d-flex justify-content-between align-items-lg-baseline">

                                            <a href="{{ route('front.category', [$category->slug, $subcategory->slug]) }}"
                                                class="{{ $isSubActive ? 'sidebar-active-color' : '' }}"
                                                data-collapse="{{ $subcategory->childs->count() > 0 ? '#' . $subId : '' }}">
                                                {{ $subcategory->name }}
                                            </a>

                                            @if ($subcategory->childs->count() > 0)
                                                <button type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $subId }}"
                                                    aria-expanded="{{ $isSubActive ? 'true' : 'false' }}"
                                                    class="{{ $isSubActive ? '' : 'collapsed' }}">
                                                    <i class="fa-solid fa-plus"></i>
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>
                                            @endif

                                        </div>

                                        @if ($subcategory->childs->count() > 0)
                                            <ul id="{{ $subId }}"
                                                class="accordion-collapse collapse ms-3 mt-2 {{ $isSubActive ? 'show' : '' }}">
                                                @foreach ($subcategory->childs as $child)
                                                    @php
                                                        $isChildActive =
                                                            $isSubActive && Request::segment(4) === $child->slug;
                                                    @endphp

                                                    <li>
                                                        <a href="{{ route('front.category', [$category->slug, $subcategory->slug, $child->slug]) }}"
                                                            class="{{ $isChildActive ? 'sidebar-active-color' : '' }}">
                                                            {{ $child->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a href="{{ route('front.category', $category->slug) }}"
                                class="{{ Request::segment(2) === $category->slug ? 'active' : '' }}">
                                    <img class="rounded me-1" style="width: 30px"
                                    src="{{ asset('assets/images/categories') }}/{{ $category->image }}"
                                    alt="{{ $category->name }}">
                                {{ $category->name }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

    </aside>
    <!-- Desktop Sidebar End -->

   <!-- Mobile Offcanvas Start-->
    <div id="mobile-offcanvas" class="mobile-offcanvas shadow ">
         <div class="offers-container mb-0">
             @foreach ($categories as $category)
                @if ($category->name == 'Family Pack')
                    <a style="font-size: 15px; color: #1598a7" href="{{ route('front.category', $category->slug) }}">

                        {{ $category->name }}
                        <img class="rounded ms-3" style="width: 50px"
                            src="{{ asset('assets/images/categories') }}/{{ $category->image }}" alt="{{ $category->name }}">
                    </a>
                @endif
            @endforeach
            <a href="{{ route('front.offers') }}" class="d-flex gap-2 align-items-center">
                <p style="font-size: 15px; color: #1598a7" class="pb-0 mb-0">
                    Offers
                    <span class="offer-outline-btn">
                        {{ App\Models\Product::where('discount', '>', 0)->count() }}
                    </span>
                    <img class="ms-3" style="width: 80px; height: auto;"
                        src="{{ asset('assets/front/images/offer.gif') }}" alt="best offer">
                </p>
            </a>
        
        </div>
        <ul class="accordion">
            @foreach ($categories as $category)
                @php
                    $isCategoryActive = Request::segment(2) === $category->slug;
                    $catId = 'cat_' . $category->slug . '_level_2';
                @endphp

                <li>
                    @if ($category->subs->count() > 0)
                        <div class="d-flex justify-content-between align-items-lg-baseline">
                           <a style="font-size: 16px;" href="{{ route('front.category', $category->slug) }}"
                                    class="{{ $isCategoryActive ? 'sidebar-active-color' : '' }}"
                                    data-collapse="#{{ $catId }}">
                                   <img class="rounded me-1" style="width: 30px" src="{{asset('assets/images/categories')}}/{{$category->image}}" alt=""> {{ $category->name }}
                                </a>

                            <button type="button" data-bs-toggle="collapse" data-bs-target="#{{ $catId }}"
                                aria-expanded="{{ $isCategoryActive ? 'true' : 'false' }}"
                                class="{{ $isCategoryActive ? '' : 'collapsed' }}">
                                <i class="fa-solid fa-plus"></i>
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </div>

                        <ul id="{{ $catId }}"
                            class="accordion-collapse collapse ms-3 {{ $isCategoryActive ? 'show' : '' }}">

                            @foreach ($category->subs as $subcategory)
                                @php
                                    $isSubActive = $isCategoryActive && Request::segment(3) === $subcategory->slug;
                                    $subId = 'sub_' . $subcategory->slug . '_lvl2';
                                @endphp

                                <li>
                                    <div class="d-flex justify-content-between align-items-lg-baseline">

                                        <a href="{{ route('front.category', [$category->slug, $subcategory->slug]) }}"
                                            class="{{ $isSubActive ? 'sidebar-active-color' : '' }}"
                                            data-collapse="{{ $subcategory->childs->count() > 0 ? '#' . $subId : '' }}">
                                            {{ $subcategory->name }}
                                        </a>

                                        @if ($subcategory->childs->count() > 0)
                                            <button type="button" data-bs-toggle="collapse"
                                                data-bs-target="#{{ $subId }}"
                                                aria-expanded="{{ $isSubActive ? 'true' : 'false' }}"
                                                class="{{ $isSubActive ? '' : 'collapsed' }}">
                                                <i class="fa-solid fa-plus"></i>
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        @endif

                                    </div>

                                    @if ($subcategory->childs->count() > 0)
                                        <ul id="{{ $subId }}"
                                            class="accordion-collapse collapse ms-3 {{ $isSubActive ? 'show' : '' }}">
                                            @foreach ($subcategory->childs as $child)
                                                @php
                                                    $isChildActive =
                                                        $isSubActive && Request::segment(4) === $child->slug;
                                                @endphp

                                                <li>
                                                    <a href="{{ route('front.category', [$category->slug, $subcategory->slug, $child->slug]) }}"
                                                        class="{{ $isChildActive ? 'sidebar-active-color' : '' }}">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a href="{{ route('front.category', $category->slug) }}"
                            class="{{ Request::segment(2) === $category->slug ? 'active' : '' }}">
                           <img class="rounded me-1" style="width: 30px"
                                    src="{{ asset('assets/images/categories') }}/{{ $category->image }}"
                                    alt="{{ $category->name }}">
                                {{ $category->name }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>

    </div>
    <!-- Mobile Offcanvas End-->



    <!-- if route is user panel then show vendor.mobile-header else show frontend.mobile_menu -->

    @php
        $url = url()->current();
        $explodeUrl = explode('/', $url);

    @endphp

    @if (in_array('user', $explodeUrl))
        <!-- frontend mobile menu -->
        @include('includes.user.mobile-header')
    @elseif(in_array('rider', $explodeUrl))
        @include('includes.rider.mobile-header')
    @else
        @include('includes.frontend.mobile_menu')
        <!-- user panel mobile sidebar -->
    @endif


    <div class="overlay"></div>
    <!-- Main Content -->
    <main id="main-content" class="main-content">

        @yield('content')
    
		@if (
    !request()->is('career') &&
    !request()->is('career/*') &&
    !request()->is('outlets') &&
    !request()->is('outlets/*') &&
    Route::currentRouteName() !== 'front.outlets'
)
        	<div class="container product-cart-offcanvas position-relative">
            <div class="text-end position-fixed" style="right: 1%; top: 50%; z-index: 999">
                @php
                    $cartObject = Session::has('cart') ? Session::get('cart') : null;
                    $cartItems = $cartObject ? $cartObject->items : [];
                @endphp

                <div class="cart-wrapper  anim" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight">
                    <div class="cart-top">
                        <img style="height: 40px; width: auto" src="{{ asset('assets/front/images/bag.gif ') }}"
                            alt="bag" />
                        <p><span class="cart-count">{{ $cartItems ? count($cartItems) : 0 }}</span> Item</p>
                    </div>

                    <div class="cart-bottom">
                        <p>৳ <span class="total_price">{{ $cartObject ? $cartObject->totalPrice : 0 }}</span></p>
                    </div>
                </div>

            </div>

            <div  class="offcanvas offcanvas-end cartOffCanva" tabindex="-1" id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel" data-bs-backdrop="false"
     data-bs-scroll="true">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel" class="mb-0 d-flex align-items-center">
                        <img style="height: 40px; width: auto" src="{{ asset('assets/front/images/bag.gif ') }}"
                            alt="" />
                        <span class="cart-total-item"><span
                                class="cart-count">{{ $cartItems ? count($cartItems) : 0 }} </span> ITEMS</span>
                    </h5>

                    <button type="button" class="close-text-btn btn border-2 btn-outline-light"
                        data-bs-dismiss="offcanvas">
                        Close
                    </button>
                </div>
        
                <div class="offcanvas-body p-0 position-relative">
                    
                   
                    <!-- Cart Items Start  -->
                    <div class="offCanva-right-cartItems">
                        @include('includes.frontend.offcanvas-cart')
                    </div>
                    <!-- Cart Items end -->
                <!-- cart footer start -->
                    <div class="order-btn-box" >
                        <a href="{{ route('front.checkout') }}" class="order-btn">
                        <span class="order-text">অর্ডার করুন</span>
                        <span class="order-price total_price text-start">{{ $cartObject ? $cartObject->totalPrice : 0 }}</span>
                    </a>
                    </div>
                    <!-- cart footer end -->
                </div>
                
             
            </div>
        </div>
        <!-- cart offcanvas End -->
 		@endif
        <!-- footer section -->
        @include('includes.frontend.footer')
        <!-- footer section -->
         {{-- Mobile bottom Shortcut Offer --}}
       
    </main>

<div id="offerPopup" class="offer-popup d-none">
        <div class="offer-header">
            <span>🎁 Special Offer Unlocked</span>
            <button title="Close" class="btn btn-sm btn-danger" onclick="closeOfferPopup()">X</button>
        </div>

        <div id="offerList" class="offer-list"></div>
    </div>

     <div class="modal fade" id="offerInfoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">🎁 এটি একটি Offer Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="offerInfoModalBody">
                    <!-- dynamic content -->
                </div>
                <div class="modal-footer border-0">
                    <p class="text-muted small w-100 text-center mb-0">
                        উপরের পরিমাণ কেনাকাটা করলে এই product টি আপনার cart এ add করতে পারবেন।
                    </p>
                    <button type="button" class="btn btn-info w-100" data-bs-dismiss="modal">
                        বুঝেছি, কেনাকাটা চালিয়ে যাই
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!--Esential Js Files-->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="{{ asset('assets/front') }}/js/jquery.min.js"></script>
    <script src="{{ asset('assets/front') }}/js/slick.js"></script>
    <script src="{{ asset('assets/front') }}/js/jquery-ui.js"></script>
    <script src="{{ asset('assets/front') }}/js/nice-select.js"></script>

    <script src="{{ asset('assets/front') }}/js/wow.js"></script>
    <script src="{{ asset('assets/front') }}/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('assets/front') }}/js/swiper-bundle.min.js"></script>

    <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/front') }}/js/script.js"></script>
    <script src="{{ asset('assets/front/js/myscript.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const closeOfferPopup = () => {
            let popup = document.getElementById("offerPopup");
            popup.classList.remove("show");
            popup.classList.add("d-none");

            setTimeout(() => popup.classList.add("show"), 10);
        }
    </script>
   <script>
        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
            zoomable: true
        });
    </script>
    <script>
    var routeTemplate = "{{ route('front.conditional-product', ':sku') }}";
</script>

    <script>
        "use strict";
        var mainurl = "{{ url('/') }}";
        var gs = {!! json_encode(
            DB::table('generalsettings')->where('id', '=', 1)->first(['is_loader', 'decimal_separator', 'thousand_separator', 'is_cookie', 'is_talkto', 'talkto']),
        ) !!};
        var ps_category = {{ $ps->category }};

        var lang = {
            'days': '{{ __('Days') }}',
            'hrs': '{{ __('Hrs') }}',
            'min': '{{ __('Min') }}',
            'sec': '{{ __('Sec') }}',
            'cart_already': '{{ __('Already Added To Card.') }}',
            'cart_out': '{{ __('Out Of Stock') }}',
            'cart_success': '{{ __('Successfully Added To Cart.') }}',
            'cart_empty': '{{ __('Cart is empty.') }}',
            'coupon_found': '{{ __('Coupon Found.') }}',
            'no_coupon': '{{ __('No Coupon Found.') }}',
            'already_coupon': '{{ __('Coupon Already Applied.') }}',
            'enter_coupon': '{{ __('Enter Coupon First') }}',
            'minimum_qty_error': '{{ __('Minimum Quantity is:') }}',
            'affiliate_link_copy': '{{ __('Affiliate Link Copied Successfully') }}'
        };
    </script>



    @php
        if (Session::has('success')) {
            echo '<script>
                toastr.success("'.Session::get('success').'")
            </script>';
        }
        if (Session::has('unsuccess')) {
            echo '<script>
                toastr.error("'.Session::get('unsuccess').'")
            </script>';
        }
    @endphp

    @yield('script')
    
    @stack('scripts')
    <script>
        // $(function() {
        //     $(".product-countdown").each(function() {
        //         var $this = $(this);
        //         var startDate = new Date($this.data("start") + " 00:00:00").getTime();
        //         var endDate = new Date($this.data("end") + " 23:59:59").getTime();
        //         var $timer = $this.find(".flash_timer");

        //         var interval = setInterval(function() {
        //             var now = new Date().getTime();

        //             if (now < startDate) {
        //                 $timer.html("⏳ Deal Not Started Yet!");
        //                 return;
        //             }

        //             if (now > endDate) {
        //                 clearInterval(interval);
        //                 $timer.html("⚡ Deal Expired!");
        //                 return;
        //             }

        //             var distance = endDate - now;

        //             let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //             let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //             let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        //             let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        //             $timer.text(
        //                 (days < 10 ? "0" + days : days) + " D:" +
        //                 (hours < 10 ? "0" + hours : hours) + " H:" +
        //                 (minutes < 10 ? "0" + minutes : minutes) + " M:" +
        //                 (seconds < 10 ? "0" + seconds : seconds) + " S Left"
        //             );
        //         }, 1000);
        //     });
        // });

         $(function() {
            $(".product-countdown").each(function() {
                var $this = $(this);
                var startDate = new Date($this.data("start") + " 00:00:00").getTime();
                var endDate = new Date($this.data("end") + " 23:59:59").getTime();
                var $wrap = $this.find(".flash-timer-wrap");

                function pad(n) {
                    return n < 10 ? "0" + n : "" + n;
                }

                var interval = setInterval(function() {
                    var now = new Date().getTime();

                    if (now < startDate) {
                        $wrap.html(
                            '<span style="font-size:13px;color:#888;">⏳ Deal not started yet</span>'
                            );
                        return;
                    }
                    if (now > endDate) {
                        clearInterval(interval);
                        $wrap.html(
                        '<span style="font-size:13px;color:#888;">⚡ Deal expired</span>');
                        return;
                    }

                    var dist = endDate - now;
                    var d = Math.floor(dist / (1000 * 60 * 60 * 24));
                    var h = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var m = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
                    var s = Math.floor((dist % (1000 * 60)) / 1000);

                    $this.find('[data-unit="days"]').text(pad(d));
                    $this.find('[data-unit="hours"]').text(pad(h));
                    $this.find('[data-unit="mins"]').text(pad(m));
                    $this.find('[data-unit="secs"]').text(pad(s));

                }, 1000);
            });
        });
        $(function () {
    $(".card-countdown").each(function () {
        var $this = $(this);
        var startDate = new Date($this.data("start") + " 00:00:00").getTime();
        var endDate = new Date($this.data("end") + " 23:59:59").getTime();
        var $badge = $this.find(".card-timer-badge");

        function pad(n) {
            return n < 10 ? "0" + n : "" + n;
        }

        var interval = setInterval(function () {
            var now = new Date().getTime();

            if (now < startDate) {
                $badge.html('<i class="ti ti-clock"></i> Soon');
                return;
            }
            if (now > endDate) {
                clearInterval(interval);
                $this.hide(); // expired হলে hide করে দাও
                return;
            }

            var dist = endDate - now;
            var d = Math.floor(dist / (1000 * 60 * 60 * 24));
            var h = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var m = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
            var s = Math.floor((dist % (1000 * 60)) / 1000);

            $this.find('[data-unit="days"]').text(pad(d));
            $this.find('[data-unit="hours"]').text(pad(h));
            $this.find('[data-unit="mins"]').text(pad(m));
            $this.find('[data-unit="secs"]').text(pad(s));

        }, 1000);
    });
});
        
    </script>

    <script>
        const searchInputs = document.querySelectorAll('.searchInput');

        searchInputs.forEach(input => {
            const parentBox = input.parentElement.parentElement;
            const searchResults = parentBox.querySelector('.searchResults');

            let typingTimer;
            const typingDelay = 200;

            input.addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                typingTimer = setTimeout(() => {
                    fetch(`{{ route('front.ajax.search') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(products => {
                            if (products.length > 0) {
                                let html = '';
                                products.forEach(p => {
                                    const productUrl =
                                        `{{ route('front.product', ':slug') }}`
                                        .replace(':slug', p.slug);

                                    html += `
                                <div class="search-item">
                                    <a href="${productUrl}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('/assets/images/products') }}/${p.photo}"
                                            alt="" style="width:40px;height:40px;margin-right:10px;">
                                            <div>
                                                <strong>${p.name}</strong><br>
                                                <span>৳ ${parseFloat(p.price).toFixed(2)}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>`;
                                });

                                searchResults.innerHTML = html;
                                searchResults.style.display = 'block';
                            } else {
                                searchResults.innerHTML =
                                    `<div class="search-item">No products found</div>`;
                                searchResults.style.display = 'block';
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            searchResults.style.display = 'none';
                        });
                }, typingDelay);
            });

            // Hide when clicked outside
            document.addEventListener('click', function(e) {
                if (!searchResults.contains(e.target) && e.target !== input) {
                    searchResults.style.display = 'none';
                }
            });
        });
    </script>
    <script>
    	  var heroSlider = new Swiper(".heroSlider", {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 8000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
        var cateSlider = new Swiper(".home-category-slider", {
            slidesPerView: 6,
            spaceBetween: 10,
            loop: true,
            speed: 500,
            autoplay: {
                delay: 1000,
                disableOnInteraction: false,
            },



            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
   <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.measure-select').forEach(select => {

                select.addEventListener('change', function() {

                    const selectedOption = this.options[this.selectedIndex];

                    const measureValue = parseFloat(selectedOption.value || 1);
                    const measurePrice = parseFloat(selectedOption.dataset.price || 0);

                    const wrapper = this.closest('.price-wrapper');
                    const priceElement = wrapper.querySelector('.product-price');

                    const basePrice = parseFloat(priceElement.dataset.basePrice);

                    let finalPrice = 0;

                    // 1️⃣ If admin set price per measure → use it
                    if (measurePrice > 0) {
                        finalPrice = measurePrice;
                    }
                    // 2️⃣ Otherwise calculate from base price
                    else {
                        finalPrice = basePrice * measureValue;
                    }

                    priceElement.textContent = finalPrice.toFixed(2) + '৳';
                });

            });

        });
    </script>
    <script>
        $(document).ready(function() {
            // ======================
            // MENU BUTTON TOGGLE
            // ======================
            $("#menu-btn").click(function() {

                if (window.innerWidth < 992) {

                    $("#mobile-offcanvas").toggleClass("active");
                    $("#barIcon").toggleClass("fa-bars-staggered fa-x");
                    $(window).resize(function() {
                        if (window.innerWidth >= 992) {
                            // Reset icon to bar
                            $("#barIcon").removeClass("fa-x").addClass("fa-bars-staggered");

                            // Offcanvas hide
                            $("#mobile-offcanvas").removeClass("active");
                        }
                    });

                } else {
                    // Desktop Sidebar Toggle
                    $("#sidebar").toggleClass("active");

                    if ($("#sidebar").hasClass("active")) {
                        $("#sidebar").css("left", "0");
                        $("#main-content").css("margin-left", "230px");
                    } else {
                        $("#sidebar").css("left", "-230px");
                        $("#main-content").css("margin-left", "0");
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Show offcanvas if last state was "open"
            if (localStorage.getItem("offcanvasCart") === "open") {
                let myOffcanvas = new bootstrap.Offcanvas("#offcanvasRight");
                myOffcanvas.show();
            }

            // When user opens the offcanvas → save state
            document.getElementById("offcanvasRight").addEventListener("shown.bs.offcanvas", function() {
                localStorage.setItem("offcanvasCart", "open");
            });

            // When user closes the offcanvas → save state
            document.getElementById("offcanvasRight").addEventListener("hidden.bs.offcanvas", function() {
                localStorage.setItem("offcanvasCart", "closed");
            });
        });
    </script>
    <!-- Search Placeholder typing animation script -->
        <script>
        const words = [
            "Fish",
            "Meat",
            "Rice",
            "Eggs",
            "Milk",
            "Fruits",
            "Vegetables",
            "Oil",
            "Snacks",
            "Drinks",
            "Baby Food",
            "Diapers",
            "Detergent",
            "Soap",
            "Shampoo"
        ];

        document.querySelectorAll(".search-box").forEach((box) => {

            const input = box.querySelector(".searchInput");
            const typingEl = box.querySelector(".typingText");
            const typingBox = box.querySelector(".typing-placeholder");

            let wordIndex = 0;
            let charIndex = 0;
            let isDeleting = false;

            function typeEffect() {

                // যদি user লিখে → stop
                if (input.value.length > 0) return;

                let currentWord = words[wordIndex];

                if (isDeleting) {
                    charIndex--;
                } else {
                    charIndex++;
                }

                typingEl.textContent = currentWord.substring(0, charIndex);

                let speed = isDeleting ? 50 : 100;

                if (!isDeleting && charIndex === currentWord.length) {
                    speed = 1200;
                    isDeleting = true;
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    wordIndex = (wordIndex + 1) % words.length;
                }

                setTimeout(typeEffect, speed);
            }

            typeEffect();

            // input change
            input.addEventListener("input", () => {
                if (input.value.length > 0) {
                    typingBox.style.display = "none";
                } else {
                    typingBox.style.display = "block";
                    typeEffect(); // restart
                }
            });
        });
    </script>
    <script>
       toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000",
};
    </script>
</body>

</html>
