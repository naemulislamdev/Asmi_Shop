@foreach ($promoOffers as $promoOffer)
    @php
        $promoOffersProducts = [];
        $ProductsId = json_decode($promoOffer->products);
        $promoOffersProducts = \App\Models\Product::whereIn('id', $ProductsId)->where('status', 1)->get();
    @endphp
    <section class="promo-offer py-4 gs-explore-product-section" style="background-image: url({{asset('assets/images/promo-offers/' . $promoOffer->bg_image)}}); background-size: cover; background-repeat: no-repeat;">
        <div class="container text-center">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6">
                    <h2 class="mb-3 text-right">🔥 {{ $promoOffer->title }}</h2>
                </div>
                <div class="col-lg-6">
                    <h2 class="mb-3 text-left">⏰ @lang('Offer end time')</h2>
                    <div class="countdown-box d-flex justify-content-center gap-3 mb-4 countdown" data-start="{{ $promoOffer->start_date }}"
     data-end="{{ $promoOffer->end_date }}">
                        <div class="time-box">
                            <span class="days">00</span>
                            <small>Days</small>
                        </div>
                        <div class="time-box">
                            <span class="hours">00</span>
                            <small>Hours</small>
                        </div>
                        <div class="time-box">
                            <span class="minutes">00</span>
                            <small>Minutes</small>
                        </div>
                        <div class="time-box">
                            <span class="seconds">00</span>
                            <small>Seconds</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="myTabContent1">
                <div class="tab-pane fade show active wow-replaced" data-wow-delay=".1s" id="ex-product-5-pane"
                    role="tabpanel" aria-labelledby="ex-product-1" tabindex="0">
                    <div class="product-cards-slider">
                        @foreach ($promoOffersProducts as $product)
                            @include('includes.frontend.home_product')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endforeach
