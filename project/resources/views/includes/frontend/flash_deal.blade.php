@if ($flashDeal)
    <section class="flash-deal py-4 gs-explore-product-section">
        <div class="container text-center">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6">
                    <h2 class="mb-3 text-right">🔥 {{ $flashDeal->title }}</h2>
                </div>
                <div class="col-lg-6">
                    <h2 class="mb-3 text-left">⏰ @lang('Offer end time')</h2>
                    <div id="countdown" class="countdown-box d-flex justify-content-center gap-3 mb-4">
                        <div class="time-box">
                            <span id="days">00</span>
                            <small>Days</small>
                        </div>
                        <div class="time-box">
                            <span id="hours">00</span>
                            <small>Hours</small>
                        </div>
                        <div class="time-box">
                            <span id="minutes">00</span>
                            <small>Minutes</small>
                        </div>
                        <div class="time-box">
                            <span id="seconds">00</span>
                            <small>Seconds</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="myTabContent1">
                <div class="tab-pane fade show active wow-replaced" data-wow-delay=".1s" id="ex-product-5-pane"
                    role="tabpanel" aria-labelledby="ex-product-1" tabindex="0">
                    <div class="product-cards-slider">
                        @foreach ($flashDealProducts as $product)
                            @include('includes.frontend.home_product')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
