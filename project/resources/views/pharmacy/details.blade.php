@extends('layouts.front')
@section('content')
    {{-- details product --}}
    <div class="container mt-3">
        {{-- Breadcumb start --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white p-0">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                </li>

                <li class="breadcrumb-item">
                    <a href="#">Category</a>
                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                </li>

                <li class="breadcrumb-item">
                    <a href="#">Sub Category</a>
                    <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    Product
                </li>
            </ol>
        </nav>
        {{-- Breadcumb End --}}
    </div>
    <div class="pharmacy-details-section py-3">
        <div class="container">
            <div>
                <div class="row">
                    <div class="col-lg-7">
                        <div class="border details-images-box p-3">
                            <div class="gap-3 small-img-box " style="max-width: 100%">
                                <div class="side-img">
                                    <img src="{{ asset('assets/pharmacy/images/cevit.jpg') }}" class="card-img thumb"
                                        alt="Product img">
                                </div>

                                <div class="side-img">
                                    <img src="{{ asset('assets/pharmacy/images/cevit-1.webp') }}" class="card-img thumb"
                                        alt="Product img">
                                </div>
                                <div class="side-img">
                                    <img src="{{ asset('assets/pharmacy/images/cevit-2.webp') }}" class="card-img thumb"
                                        alt="Product img">
                                </div>

                            </div>
                            <div class="position-relative big-image-box" style="max-height: 100%">
                                <a style="cursor: zoom-in; " href="{{ asset('assets/pharmacy/images/cevit.jpg') }}"
                                    class="glightbox" data-gallery="products">
                                    <img style="max-height: 100%" src="{{ asset('assets/pharmacy/images/cevit.jpg') }}"
                                        class="card-img" alt="Product img">
                                </a>
                                {{-- Product others images --}}
                                <a href="{{ asset('assets/pharmacy/images/cevit-1.webp') }}" class="glightbox d-none"
                                    data-gallery="products"></a>

                                <a href="{{ asset('assets/pharmacy/images/cevit-2.webp') }}" class="glightbox d-none"
                                    data-gallery="products"></a>
                            </div>
                        </div>
                        {{-- Mobile Add to cart and price area start --}}
                        <div class="card medicine-price-quantity d-block d-lg-none" style="border-radius: 12px">
                            <div class="card-header pb-0 bg-dark d-flex align-items-center"
                                style="border-radius: 12px 12px 0 0">
                                <p style="width: 70%;" class="text-white">ব্যবসার জন্য পাইকারি দামে পণ্য কিনতে
                                    রেজিস্টেশন
                                    করুন</p>
                                <div class="text-right" style="width: 30%">
                                    <a class="btn btn-primary  w-100 rounded-pill">
                                        Register

                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="body-container">
                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                        <div>
                                            <h3 class="card-title">Ceevit</h3>
                                            <p class="card-text">Tablet
                                                - (250mg)</p>
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/pharmacy/images/icons/social-media.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="company-info d-flex align-items-center py-2 border-bottom">
                                        <div class="logo">
                                            <img width="40px; height: auto;"
                                                src="{{ asset('assets/pharmacy/images/company/3.png') }}" alt="">
                                        </div>
                                        <div class="c-name">
                                            <p>Square Pharmaceuticals PLC. <i class="fa fa-caret-right"
                                                    aria-hidden="true"></i>
                                            </p>


                                        </div>
                                    </div>
                                    <div class="generic-info d-flex align-items-center py-3  border-bottom">
                                        <div class="icon">
                                            <img src="{{ asset('assets/pharmacy/images/icons/generic.png') }}"
                                                alt="">
                                        </div>
                                        <p class="mb-0">Generic: <span>Vitamin C (Ascorbic Acid)</span></p>
                                    </div>
                                    <div class="quantity-price py-2">
                                        <h6 class="quantity">
                                            10 Tablets (1 Strip)
                                        </h6>
                                        <div class="price-discount d-flex mt-3">
                                            <h5 class="mb-0">৳ 18.50
                                                <span class="text-decoration-line-through">৳ 19</span>
                                            </h5>
                                            <div class="discount-card position-relative ms-4">
                                                <div class="offer-ribbon">
                                                    3% OFF
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        {{-- <button class="btn btn-lg addToCartBtn">Add to Cart</button> --}}
                                        <!-- From Uiverse.io by adeladel522 -->
                                        <button class="addToCartBtn">
                                            Add to Cart
                                            <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                                stroke="currentColor" fill="none" viewBox="0 0 24 24" height="24"
                                                width="24" xmlns="http://www.w3.org/2000/svg">
                                                <circle r="1" cy="21" cx="9"></circle>
                                                <circle r="1" cy="21" cx="20"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                                </path>
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                                <div class="alternative-products-section p-2 mt-4">
                                    <h5 class="border-bottom pb-2">
                                        Alternative Brands For <strong style="color: #1bb9cb">Ceevit</strong>
                                    </h5>
                                    <div class="alternative-products">
                                        @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $item)
                                            <a href="#" class="product row align-items-center">
                                                <div class="col-2 ps-0 mb-3">
                                                    <img src="{{ asset('assets/pharmacy/images/alternative/p-' . $item . '.webp') }}"
                                                        alt="">

                                                </div>
                                                <div class="name-company col-6 ps-0">
                                                    <h5>Nutrivit C 250</h5>
                                                    <p>By ACI Limited</p>
                                                </div>
                                                <div class="price_type col-4 ps-0">
                                                    <h5>৳1.73/Tablet</h5>
                                                    <p>Save 7%</p>
                                                </div>
                                            </a>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Mobile Add to cart and price area End --}}
                        <div class="medicine-overview border mt-4 p-3" style="border-radius: 15px">
                            <div class="overview-title">
                                <h5><img style="width: 40px; height: auto"
                                        src="{{ asset('assets/pharmacy/images/icons/drug-info.png') }}" alt="">
                                    Medicine Overview of Ceevit 250mg Tablet</h5>
                            </div>
                            <div class="overview-body">
                                <h6>Indication</h6>
                                <p>Treatment or prevention of, Vitamin C Deficiency, Scurvy, Infection, Trauma, Burns, Cold
                                    exposure, Following Surgery, common cold, Fever, scurvy, Stress, Cancer,
                                    Methaemoglobinaemia and Children receiving unfortified formulas. Also indicated in,
                                    Hematuria, Dental Caries, Gum Diseases, Pyorrhea, Acne, Infertility, Atherosclerosis,
                                    Fractures, Leg ulcers, Hay fever, Vascular thrombosis prevention, Levodopa toxicity,
                                    Arsenic toxicity.</p>
                                <h6>Administration</h6>
                                <p>May be taken with or without food. IV Preparation Dilute with large volume of compatible
                                    fluid to minimize adverse reactions Compatible w/ most common diluents (dextrose solns,
                                    NS, LR, Ringer's, ½NS, dextrose-saline, dextrose-LR etc) IV Administration Avoid rapid
                                    infusion</p>
                                <h6>Adult Dose
                                </h6>
                                <p>Oral Scurvy Adult: Prevention: 25-75 mg daily. 4 tablets 2 to 3 times daily. Treatment:
                                    >250 mg daily, given in divided doses. May also be given via IM/IV/SC admin. 250-500mg
                                    IV qDay/BID for at least 2 weeks. Thalassaemia Adult: 100-200 mg daily, to be given with
                                    desferrioxamine. Common cold: 1 gm or more daily in divided doses, i.e. 4 tablets daily.
                                    In wound healing: 2-4 tablets 2 to 3 times daily In other conditions: 1-2 tablets daily
                                    For the reduction of risk of stroke in the elderly: 1-2 tablets daily. 1 effervescent
                                    tablet daily with a meal or as directed...</p>
                                <h6>Child Dose
                                </h6>
                                <p>Children: Child: 1 mth-4 yr: 125-250 mg daily; 4-12 yr: 250-500 mg daily; 12-18 yr: 500
                                    mg-1 g daily. Doses to be given in 1-2 divided doses. Thalassaemia Child: 100-200 mg
                                    daily, to be given with desferrioxamine. Metabolic disorders Child: Neonate: 50-200 mg
                                    daily, adjust if needed; 1 mth-18 yr: 200-400 mg daily in 1-2 divided doses, up to 1 g
                                    daily may be needed.</p>
                                <h6>Mode of Action
                                </h6>
                                <p>Vitamin C: Necessary for collagen formation and tissue repair; plays a role in
                                    oxidation/reduction reactions as well as other metabolic pathways including synthesis of
                                    catecholamines, carnitine, and steroids; also plays a role in conversion of folic acid
                                    to folinic acid.</p>
                                <h6>Precaution
                                </h6>
                                <p>Should be given with caution to patient with hyperoxaluria.
                                </p>
                                <h6>Side Effect

                                </h6>
                                <p>Flushing, Flank pain, Faintness, headache, Diarrhea, dyspepsia, nausea, vomiting,
                                    Hyperoxaluria (large doses)

                                </p>
                                <h6>Interaction</h6>
                                <p>Vit C: Deferroxamine, hormonal contraceptives, flufenazine, warfarin, elemental iron,
                                    salicylates, warfarin, fluphenazine, disulfiram, mexiletine, vitamin B12.


                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card medicine-price-quantity d-none d-lg-block" style="border-radius: 12px">
                            <div class="card-header pb-0 bg-dark d-flex align-items-center"
                                style="border-radius: 12px 12px 0 0">
                                <p style="width: 70%;" class="text-white">ব্যবসার জন্য পাইকারি দামে পণ্য কিনতে
                                    রেজিস্টেশন
                                    করুন</p>
                                <div class="text-right" style="width: 30%">
                                    <a class="btn btn-primary  w-100 rounded-pill">
                                        Register

                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="body-container">
                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                        <div>
                                            <h3 class="card-title">Ceevit</h3>
                                            <p class="card-text">Tablet
                                                - (250mg)</p>
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/pharmacy/images/icons/social-media.png') }}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="company-info d-flex align-items-center py-2 border-bottom">
                                        <div class="logo">
                                            <img width="40px; height: auto;"
                                                src="{{ asset('assets/pharmacy/images/company/3.png') }}" alt="">
                                        </div>
                                        <div class="c-name">
                                            <p>Square Pharmaceuticals PLC. <i class="fa fa-caret-right"
                                                    aria-hidden="true"></i>
                                            </p>


                                        </div>
                                    </div>
                                    <div class="generic-info d-flex align-items-center py-3  border-bottom">
                                        <div class="icon">
                                            <img src="{{ asset('assets/pharmacy/images/icons/generic.png') }}"
                                                alt="">
                                        </div>
                                        <p class="mb-0">Generic: <span>Vitamin C (Ascorbic Acid)</span></p>
                                    </div>
                                    <div class="quantity-price py-2">
                                        <h6 class="quantity">
                                            10 Tablets (1 Strip)
                                        </h6>
                                        <div class="price-discount d-flex mt-3">
                                            <h5 class="mb-0">৳ 18.50
                                                <span class="text-decoration-line-through">৳ 19</span>
                                            </h5>
                                            <div class="discount-card position-relative ms-4">
                                                <div class="offer-ribbon">
                                                    3% OFF
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        {{-- <button class="btn btn-lg addToCartBtn">Add to Cart</button> --}}
                                        <!-- From Uiverse.io by adeladel522 -->
                                        <button class="addToCartBtn">
                                            Add to Cart
                                            <svg stroke-linejoin="round" stroke-linecap="round" stroke-width="2"
                                                stroke="currentColor" fill="none" viewBox="0 0 24 24" height="24"
                                                width="24" xmlns="http://www.w3.org/2000/svg">
                                                <circle r="1" cy="21" cx="9"></circle>
                                                <circle r="1" cy="21" cx="20"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                                </path>
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                                <div class="alternative-products-section p-2 mt-4">
                                    <h5 class="border-bottom pb-2">
                                        Alternative Brands For <strong style="color: #1bb9cb">Ceevit</strong>
                                    </h5>
                                    <div class="alternative-products">
                                        @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $item)
                                            <a href="#" class="product row align-items-center">
                                                <div class="col-2 ps-0 mb-3">
                                                    <img src="{{ asset('assets/pharmacy/images/alternative/p-' . $item . '.webp') }}"
                                                        alt="">

                                                </div>
                                                <div class="name-company col-6 ps-0">
                                                    <h5>Nutrivit C 250</h5>
                                                    <p>By ACI Limited</p>
                                                </div>
                                                <div class="price_type col-4 ps-0">
                                                    <h5>৳1.73/Tablet</h5>
                                                    <p>Save 7%</p>
                                                </div>
                                            </a>
                                        @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Product section --}}
    <div style="background: rgba(0, 94, 254, 0.2)" class="gs-pharmacy-product-section py-3 mt-">
        <div class="container">
            <div class="section-title">
                <h2 class="pt-3">You May Also Like</h2>
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
    {{-- Product section --}}
    <div style="background: rgba(132, 5, 7, 0.2)" class="gs-pharmacy-product-section py-3 mt-">
        <div class="container">
            <div class="section-title">
                <h2 class="pt-3">More from Square Pharmaceuticals PLC.</h2>
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
    {{-- Desclaimer section --}}
    <div class="gs-desclimer-section py-3 mt-">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="desclimer-box">
                        <div class="des_heading d-flex align-items-center gap-3 mb-2">
                            <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i>
                            <h6 class="text-danger mb-0">Disclaimer</h6>
                        </div>
                        <div class="des-body">
                            <p>The information presented here is accurate, up to date, and complete to the best of the
                                Company’s knowledge and standard practices. However, this content is intended for general
                                informational purposes only and should not be considered a substitute for professional
                                medical advice or in-person consultation. While we strive to ensure accuracy, the Company
                                does not warrant or guarantee the completeness or reliability of the information provided.
                                The absence of specific details, warnings, or precautions for any medication should not be
                                interpreted as an implied assurance by the Company. We disclaim all responsibility for any
                                consequences arising from the use of this information and strongly advise consulting a
                                qualified healthcare professional for any questions, concerns, or medical decisions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const bigImageBox = document.querySelector('.big-image-box');
            if (!bigImageBox) return;

            const mainLink = bigImageBox.querySelector('a.glightbox');
            const mainImage = mainLink.querySelector('img');

            const smallImages = document.querySelectorAll('.small-img-box img');
            if (smallImages.length === 0) return;

            /* 🔹 1. Default first image active */
            const firstImg = smallImages[0];
            mainImage.src = firstImg.src;
            mainLink.href = firstImg.src;
            firstImg.classList.add('active');

            /* 🔹 2. Click logic */
            smallImages.forEach(img => {
                img.addEventListener('click', function() {
                    const newSrc = this.getAttribute('src');

                    // remove active from all
                    smallImages.forEach(i => i.classList.remove('active'));

                    // add active to clicked
                    this.classList.add('active');

                    // fade effect
                    mainImage.style.transition = 'opacity 0.3s ease';
                    mainImage.style.opacity = '0';

                    setTimeout(() => {
                        mainImage.src = newSrc;
                        mainLink.href = newSrc;
                        mainImage.style.opacity = '1';
                    }, 300);
                });
            });

        });
    </script>
@endsection
