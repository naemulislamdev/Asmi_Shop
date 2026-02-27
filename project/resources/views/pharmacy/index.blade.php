@extends('layouts.front')
@section('content')
    <section class="gs-pharmacy-slider-section my-3">
        <div class="container">
            <!-- Swiper -->
            <div class="swiper mySwiper" style="">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/slider-1.webp') }}" alt="">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/slider-2.webp') }}" alt="">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/slider-3.webp') }}" alt="">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/slider-4.webp') }}" alt="">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/slider-5.webp') }}" alt="">
                        </a>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>
    <section class="gs-pharmacy-quick-link-section my-3  mt-4">
        <div class="container">
            <h2 class="text-center">Only For You
            </h2>
            <div class="swiper product-swiper mt-4">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="offer-card offer-green ">
                            <div class="offer-icon bg-success">
                                <i class="fab fa-whatsapp"></i>
                            </div>

                            <h6>Order</h6>
                            <h5 class="fw-bold text-center">Via WhatsApp</h5>
                            <p class="mb-2">01810117100</p>

                            <a href="#" class="btn btn-light btn-block text-success mt-3">
                                Call Now
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="offer-card offer-blue">
                            <div class="offer-icon bg-info">
                                <i class="fas fa-file-medical"></i>
                            </div>

                            <h6>UPTO</h6>
                            <h4 class="fw-bold">10% OFF</h4>
                            <p>+ Cashback</p>

                            <a href="#" class="btn btn-light btn-block text-info">
                                Upload Prescription
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="offer-card offer-lime">
                            <div class="offer-icon bg-green">
                                <i class="fas fa-store"></i>
                            </div>

                            <h6>UPTO</h6>
                            <h4 class="fw-bold">14% OFF</h4>
                            <p>+ Cashback</p>

                            <a href="#" class="btn btn-light btn-block text-success">
                                Register Pharmacy
                            </a>
                        </div>
                    </div>
                    <!-- Slide -->


                    <div class="swiper-slide">
                        <div class="offer-card offer-purple">
                            <!-- Top Icon -->
                            <div class="offer-icon bg-purple">
                                <i class="fas fa-pills"></i>
                            </div>
                            <h6>UPTO</h6>
                            <h4 class="fw-bold">60% OFF</h4>
                            <p>+ Cashback</p>

                            <a href="#" class="btn btn-light btn-block text-purple">
                                HealthCare
                            </a>

                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="offer-card offer-orange">
                            <!-- Top Icon -->
                            <div class="offer-icon bg-orange">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-headset">
                                    <path
                                        d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z" />
                                    <path d="M21 16v2a4 4 0 0 1-4 4h-5" />
                                </svg>
                            </div>
                            <h6>UPTO</h6>
                            <h4 class="fw-bold">10% OFF</h4>
                            <p><i class="fa fa-phone"></i> 16778</p>

                            <a href="#" class="btn btn-light btn-block text-orange">
                                Call To Order
                            </a>

                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="offer-card offer-red">
                            <!-- Top Icon -->
                            <div class="offer-icon bg-red">
                                <i class="fa fa-flask" aria-hidden="true"></i>
                            </div>
                            <h6>UPTO</h6>
                            <h4 class="fw-bold">25% OFF</h4>


                            <a href="#" class="btn btn-light btn-block text-red mt-5">
                                Lab Test
                            </a>

                        </div>
                    </div>
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

        </div>
    </section>

    <div style="background-color: rgba(222, 140, 26, 0.20);" class="gs-pharmacy-product-section py-3">
        <div class="container">
            <div class="section-title">
                <div>
                    <h2 class="pt-3">Preparing for Ramadan?✨🌙</h2>
                    <p class="m-0">Shop Now!</p>
                </div>
                <a class="btn btn-outline-primary btn-sm" href="#"><i class="fa fa-eye"></i> See all</a>
            </div>
            <div class="swiper product-swiper mt-4">
                <div class="swiper-wrapper">
                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $item)
                        <div class="swiper-slide">
                            <div class="product-card">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ route('pharmacy.details') }}">
                                        <img class="card-img"
                                            src="{{ asset('assets/pharmacy/images/feature/medicine/med-' . $item . '.webp') }}"
                                            alt="Medicine {{ $item }}">
                                    </a>
                                    <div class="offer-badge">2% OFF</div>
                                </div>
                                <div class="p-3 card-content">
                                    <div class="delivery-info">
                                        <button class="btn btn-sm rounded-pill offer-time">
                                            <i class="fas fa-clock"></i> 12-24 Hours
                                        </button>
                                    </div>
                                    <div class="product-title">
                                        <a href="{{ route('pharmacy.details') }}">
                                            <h5>Losectil 40</h5>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="product-price">
                                            <span class="old-price">৳ 90</span>
                                            <span class="text-dark">৳ 82.97</span>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm cart-add">ADD</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <div style="background: rgba(0, 94, 254, 0.2)" class="gs-pharmacy-product-section py-3 mt-">
        <div class="container">
            <div class="section-title">
                <h2 style="color: #1bb9cb" class="pt-3">Best Selling Products
                </h2>
                <a class="btn btn-outline-primary btn-sm" href="#"><i class="fa fa-eye"></i> See all</a>
            </div>
            <div class="swiper product-swiper mt-4">
                <div class="swiper-wrapper">
                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $item)
                        <div class="swiper-slide">
                            <div class="product-card">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ route('pharmacy.details') }}">
                                        <img class="card-img"
                                            src="{{ asset('assets/pharmacy/images/feature/medicine/med-' . $item . '.webp') }}"
                                            alt="Medicine {{ $item }}">
                                    </a>
                                    <div class="offer-badge">2% OFF</div>
                                </div>
                                <div class="p-3 card-content">
                                    <div class="delivery-info">
                                        <button class="btn btn-sm rounded-pill offer-time">
                                            <i class="fas fa-clock"></i> 12-24 Hours
                                        </button>
                                    </div>
                                    <div class="product-title">
                                        <a href="{{ route('pharmacy.details') }}">
                                            <h5>Losectil 40</h5>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="product-price">
                                            <span class="old-price">৳ 90</span>
                                            <span class="text-dark">৳ 82.97</span>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm cart-add">ADD</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

        </div>
    </div>
    <div style="background: rgba(0, 94, 254, 0.2)" class="gs-pharmacy-product-section py-3 mt-">
        <div class="container">
            <div class="section-title">
                <h2 class="pt-3">OTC Medicine</h2>
                <a class="btn btn-outline-primary btn-sm" href=""><i class="fa fa-eye"></i> See all</a>
            </div>
            <div class="swiper product-swiper mt-4">
                <div class="swiper-wrapper">
                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $item)
                        <div class="swiper-slide">
                            <div class="product-card">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ route('pharmacy.details') }}">
                                        <img class="card-img"
                                            src="{{ asset('assets/pharmacy/images/feature/medicine/med-' . $item . '.webp') }}"
                                            alt="Medicine {{ $item }}">
                                    </a>
                                    <div class="offer-badge">2% OFF</div>
                                </div>
                                <div class="p-3 card-content">
                                    <div class="delivery-info">
                                        <button class="btn btn-sm rounded-pill offer-time">
                                            <i class="fas fa-clock"></i> 12-24 Hours
                                        </button>
                                    </div>
                                    <div class="product-title">
                                        <a href="{{ route('pharmacy.details') }}">
                                            <h5>Losectil 40</h5>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="product-price">
                                            <span class="old-price">৳ 90</span>
                                            <span class="text-dark">৳ 82.97</span>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm cart-add">ADD</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <div style="background:rgba(132, 5, 7, 0.2)" class="gs-pharmacy-product-section py-3 mt-">
        <div class="container">
            <div class="section-title">
                <div>
                    <h2 class="pt-3">Flash Sale</h2>
                    <p>Up to 83% discount for limited time 🔥
                    </p>
                </div>
                <a class="btn btn-outline-primary btn-sm" href=""><i class="fa fa-eye"></i> See all</a>
            </div>
            <div class="swiper product-swiper mt-4">
                <div class="swiper-wrapper">
                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $item)
                        <div class="swiper-slide">
                            <div class="product-card">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ route('pharmacy.details') }}">
                                        <img class="card-img"
                                            src="{{ asset('assets/pharmacy/images/feature/medicine/med-' . $item . '.webp') }}"
                                            alt="Medicine {{ $item }}">
                                    </a>
                                    <div class="offer-badge">2% OFF</div>
                                </div>
                                <div class="p-3 card-content">
                                    <div class="delivery-info">
                                        <button class="btn btn-sm rounded-pill offer-time">
                                            <i class="fas fa-clock"></i> 12-24 Hours
                                        </button>
                                    </div>
                                    <div class="product-title">
                                        <a href="{{ route('pharmacy.details') }}">
                                            <h5>Losectil 40</h5>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="product-price">
                                            <span class="old-price">৳ 90</span>
                                            <span class="text-dark">৳ 82.97</span>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm cart-add">ADD</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <div class="gs-pharmacy-slider-section my-3">
        <div class="container">
            <!-- Swiper -->
            <div class="swiper mySwiper" style="">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/mid-slider-1.webp') }}" alt="">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/mid-slider-2.webp') }}" alt="">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/mid-slider-3.webp') }}" alt="">
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('assets/pharmacy/images/mid-slider-4.webp') }}" alt="">
                        </a>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </div>
    <div style="background:rgba(147, 207, 147, 0.2)" class="gs-pharmacy-product-section py-3 mt-">
        <div class="container">
            <div class="section-title">
                <div>
                    <h2 class="pt-3">Protect Your Health🩺
                    </h2>

                </div>
                <a class="btn btn-outline-primary btn-sm" href=""><i class="fa fa-eye"></i> See all</a>
            </div>
            <div class="swiper product-swiper mt-4">
                <div class="swiper-wrapper">

                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $item)
                        <div class="swiper-slide">
                            <div class="product-card">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ route('pharmacy.details') }}">
                                        <img class="card-img"
                                            src="{{ asset('assets/pharmacy/images/device/dev-' . $item . '.webp') }}"
                                            alt="Medicine {{ $item }}">
                                    </a>
                                    <div class="offer-badge">2% OFF</div>
                                </div>
                                <div class="p-3 card-content">
                                    <div class="delivery-info">
                                        <button class="btn btn-sm rounded-pill offer-time">
                                            <i class="fas fa-clock"></i> 12-24 Hours
                                        </button>
                                    </div>
                                    <div class="product-title">
                                        <a href="{{ route('pharmacy.details') }}">
                                            <h5>Product Name Here</h5>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="product-price">
                                            <span class="old-price">৳ 90</span>
                                            <span class="text-dark">৳ 82.97</span>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm cart-add">ADD</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    {{-- featured category section --}}
    <div style="background:#fff" class="gs-pharmacy-featured-section py-3 mt-">
        <div class="container">
            <div class="section-title">
                <div>
                    <h2 class="pt-3">Featured Categories</h2>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/hair.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Haircare</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/mother-care.png') }}"
                                alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Mother Care</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/bath.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Bath & Body</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/baby.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Baby Feeding</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/cook.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Cooking & Baking</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/house-hold.webp') }}"
                                alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Household Cleaning</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/breack-fast.png') }}"
                                alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Breakfast, Diet & Nutrition</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/medical-device.webp') }}"
                                alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Medical Devices</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/diaper.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Diapers</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/cat.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Cat</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/pest.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Pest Control</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/seeds.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Seeds</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/honey.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Honey</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/snacks.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Snacks & Beverages</p>
                    </a>
                </div>
                <div class="col-3 col-md-2 mb-3">
                    <a href="#" class="text-center featured-box">
                        <div class="img-box">
                            <img src="{{ asset('assets/pharmacy/images/feature/vejos.webp') }}" alt="Lux Travel Bag">
                        </div>
                        <p class="text-center feature-title">Digestive & Vitality Support</p>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div style="background:rgba(147, 207, 147, 0.2)" class="gs-pharmacy-product-section py-3 mt-">
        <div class="container">
            <div class="section-title">
                <div>
                    <h2 class="pt-3">Baby Care 👶🍼
                    </h2>

                </div>
                <a class="btn btn-outline-primary btn-sm" href=""><i class="fa fa-eye"></i> See all</a>
            </div>
            <div class="swiper product-swiper mt-4">
                <div class="swiper-wrapper">

                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $item)
                        <div class="swiper-slide">
                            <div class="product-card">
                                <div class="position-relative overflow-hidden">
                                    <a href="{{ route('pharmacy.details') }}">
                                        <img class="card-img"
                                            src="{{ asset('assets/pharmacy/images/baby/baby-' . $item . '.webp') }}"
                                            alt="Medicine {{ $item }}">
                                    </a>
                                    <div class="offer-badge">2% OFF</div>
                                </div>
                                <div class="p-3 card-content">
                                    <div class="delivery-info">
                                        <button class="btn btn-sm rounded-pill offer-time">
                                            <i class="fas fa-clock"></i> 12-24 Hours
                                        </button>
                                    </div>
                                    <div class="product-title">
                                        <a href="{{ route('pharmacy.details') }}">
                                            <h5>Product Name Here</h5>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="product-price">
                                            <span class="old-price">৳ 90</span>
                                            <span class="text-dark">৳ 82.97</span>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm cart-add">ADD</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <!-- Partner Section -->
    <section class="gs-partner-section">
        <div class="container">
            <div class="gs-partnerss gy-4 row justify-content-center">

                @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12] as $data)
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6 wow-replaced" data-wow-delay=".1s">
                        <div class="single-partner">
                            <img src="{{ asset('assets/pharmacy/images/company/' . $data . '.png') }}"
                                alt="Partner {{ $data }}" loading="lazy">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>
    <!-- Partner Section Completed -->
@endsection
