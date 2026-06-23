@extends('layouts.front')

@section('content')
    <style>
        .gs-hero-section img {
            width: 100%;
            height: 100%;
            /* You can adjust this height based on your design */
            background-size: cover;
            /* Ensures the image fills the area */
            background-position: center;
            /* Keeps focus on the center */
            background-repeat: no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        .gs-hero-section {
            height: auto;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .gs-hero-section {
                height: 160px;
            }

            .gs-hero-section img {
                height: 100%;
                /* Smaller height for mobile */
                background-position: center top;
            }
        }
    </style>
    <style>
        .flash-deal {
            background: url('assets/front/images/weeklyoffer-bg.png');
            /* border: 2px solid #ff9800; */
            border-radius: 10px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 100% 100%;
        }

        .countdown-box .time-box {
            background: #fff;
            border: 2px solid #ff9800;
            border-radius: 8px;
            padding: 5px 5px;
            min-width: 80px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .countdown-box span {
            font-size: 17px;
            font-weight: bold;
            color: #e65100;
            display: block;
        }

        .countdown-box small {
            font-size: 14px;
            color: #555;
        }

        .gs-partner-section .col-xl-2 {
            flex: 0 0 auto;
            width: 16%;
        }

        .slider-section .card img {
            border-radius: 10px !important;
        }

        /* hero slider change styel */
        .hero-slider-wrapper .slick-prev {
            left: 0%;
            background-color: rgba(27, 185, 203, 0.4);
            /* Blur effect */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            /* for Safari */
        }

        .hero-slider-wrapper .slick-next {
            right: 0%;
            background-color: rgba(27, 185, 203, 0.4);
            /* Blur effect */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            /* for Safari */
        }

        .hero-slider-wrapper .slick-next:hover,
        .hero-slider-wrapper .slick-prev:hover {
            background: #1bb9cb;
        }

        .slider-section .left-promo .card,
        .slider-section .right-promo .card {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
        }

        .home-coupon-slider .coupon-item img {
            max-width: 100%;
            height: auto;
        }

        /* Previous arrow */
        .home-coupon-slider .slick-prev {
            background-color: rgba(27, 185, 203, 0.4);
            color: #1bb9cb;
            height: 30px;
            width: 30px;
            line-height: 30px;
            border-radius: 50%;
            position: absolute;
            top: 35%;
            left: 0;
            /* adjust distance from left */
            z-index: 999;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            border: 2px solid #1bb9cb;
            /* Blur effect */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            /* for Safari */
        }

        /* Next arrow */
        .home-coupon-slider .slick-next {
            background-color: rgba(27, 185, 203, 0.4);
            color: #1bb9cb;
            height: 30px;
            width: 30px;
            line-height: 30px;
            border-radius: 50%;
            position: absolute;
            top: 35%;
            right: -5px;
            /* adjust distance from right */
            z-index: 999;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            border: 2px solid #1bb9cb;
            /* Blur effect */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            /* for Safari */
        }

        /* Optional: remove default arrows background on hover */
        .home-coupon-slider .slick-prev:hover,
        .home-coupon-slider .slick-next:hover {
            background-color: #17a1b1;
            color: #fff;
        }

        .left-promo .slick-track {
            transform: translate3d(0, 0, 0) !important;
        }

        .left-promo .slick-slide {
            width: 100% !important;
        }

        .left-promo .slick-dots,
        .right-promo .slick-dots {
            margin-top: 0;
        }

        .left-promo .slick-dots li.slick-active button {
            width: 30px;
        }

        .right-promo .slick-dots li.slick-active button {
            width: 30px;
        }

        /* 22 Feb 26 */
        .hero-slider .swiper-horizontal>.swiper-pagination-bullets,
        .hero-slider .swiper-pagination-bullets.swiper-pagination-horizontal,
        .hero-slider .swiper-pagination-custom,
        .hero-slider .swiper-pagination-fraction {
            bottom: -1px !important;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 18px;
            font-weight: bold;
        }

        .category-item {
            background: #fff;
            border-radius: 6px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
            text-align: center;
            padding-bottom: 0;
        }

        .category-item img {
            max-width: 100%;
            height: 107px;
            object-fit: contain;
            border-radius: 6px 6px 0 0;
        }

        /* wrapper stretch */
        .home-category-slider .swiper-wrapper {
            align-items: stretch;
        }

        /* slide full height */
        .home-category-slider .swiper-slide {
            height: auto;
            display: flex;
        }

        /* link full height */
        .slide-link {
            display: flex;
            width: 100%;
        }

        /* card full height */
        .gs-single-cat {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
            background: #fff;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
        }

        /* image fixed height */
        .cate-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        /* title bottom align */
        .cate-title {
            margin-top: auto;
            text-align: center;
        }

        .cate-title h6 {
            font-size: 16px;
        }

        .swiper-pagination-bullet {
            width: var(--swiper-pagination-bullet-width,
                    var(--swiper-pagination-bullet-size, 12px));
            height: var(--swiper-pagination-bullet-height,
                    var(--swiper-pagination-bullet-size, 12px));
        }

        .swiper-pagination-bullet-active {
            background: #1bb9cb !important;
        }
    </style>


    <!-- Explore Product Section -->
    <section class="gs-explore-product-section bg-light-white">
        <div class="container">
            <!-- title box  & nav-tab -->
            <div class="row mb-36 justify-content-center">
                <div class="col-12">
                    <div class="gs-title-box text-center my-3">
                        <h2 class="title wow-replaced">@lang('Popular Products')</h2>
                    </div>
                </div>
            </div>

            <!-- tab content -->
            <div class="row">
                @foreach ($popularProducts as $product)
                   @include('includes.frontend.home_product')
                @endforeach
            </div>
        </div>
    </section>
    <!-- Explore Product Section Completed -->
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("[data-background]").forEach(function(el) {
                const bg = el.getAttribute("data-background");
                if (bg) {
                    el.style.backgroundImage = `url('${bg}')`;
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".home-slider").forEach(function(img) {
                img.addEventListener("click", function() {
                    let url = this.getAttribute("data-href");
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {
            // ✅ Get start & end date dynamically from DB
            var startDate = new Date("{{ $flashDeal->start_date ?? '' }} 00:00:00").getTime();
            var endDate = new Date("{{ $flashDeal->end_date ?? '' }} 23:59:59").getTime();

            var timer = setInterval(function() {
                var now = new Date().getTime();

                // 1️⃣ Before start date
                if (now < startDate) {
                    $("#countdown").html("<h3>⏳ Deal Not Started Yet!</h3>");
                    return;
                }

                // 2️⃣ After end date
                if (now > endDate) {
                    clearInterval(timer);
                    $("#countdown").html("<h3>⚡ Deal Expired!</h3>");
                    return;
                }

                // 3️⃣ Countdown running
                var distance = endDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $("#days").text(days < 10 ? "0" + days : days);
                $("#hours").text(hours < 10 ? "0" + hours : hours);
                $("#minutes").text(minutes < 10 ? "0" + minutes : minutes);
                $("#seconds").text(seconds < 10 ? "0" + seconds : seconds);
            }, 1000);
        });
    </script>
    <script>
        $(function() {

            $('.countdown').each(function() {

                let $this = $(this);

                let startDate = new Date($this.data('start') + " 00:00:00").getTime();
                let endDate = new Date($this.data('end') + " 23:59:59").getTime();

                let timer = setInterval(function() {

                    let now = new Date().getTime();

                    // Before start
                    if (now < startDate) {
                        $this.html("<h5>⏳ Deal Not Started Yet!</h5>");
                        return;
                    }

                    // After end
                    if (now > endDate) {
                        clearInterval(timer);
                        $this.html("<h5>⚡ Deal Expired!</h5>");
                        return;
                    }

                    // Running
                    let distance = endDate - now;

                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    $this.find('.days').text(days < 10 ? "0" + days : days);
                    $this.find('.hours').text(hours < 10 ? "0" + hours : hours);
                    $this.find('.minutes').text(minutes < 10 ? "0" + minutes : minutes);
                    $this.find('.seconds').text(seconds < 10 ? "0" + seconds : seconds);

                }, 1000);

            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var closeBtn = document.getElementById('close-pModal');
            if (closeBtn) { // ← null check অবশ্যই লাগবে
                closeBtn.addEventListener('click', function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('popup-modal'));
                    if (modal) modal.hide();
                });
            }
        });
    </script>
@endpush
