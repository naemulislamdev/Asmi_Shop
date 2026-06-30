@extends('layouts.front')
<style>
  
    /* ==================================Promo Offer style start=====================================*/

    .promoOfferWrap {
        padding: 10px 0 4px;
    }

    .promoOfferLabel {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.07em;
        color: #888;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .promoOfferList {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .promoOfferCard {
        display: flex;
        align-items: stretch;
        border-radius: 10px;
        border: 0.5px solid #ddd;
        overflow: hidden;
        background: #fff;
        transition: border-color 0.15s, transform 0.12s;
        cursor: default;
    }

    .promoOfferCard:hover {
        border-color: #aaa;
        transform: translateY(-1px);
    }

    .promoOfferAccent {
        width: 5px;
        flex-shrink: 0;
    }

    .promoOfferBody {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
    }

    .promoOfferIcon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .promoOfferText {
        flex: 1;
    }

    .promoOfferThreshold {
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .promoOfferDesc {
        font-size: 13px;
        color: #222;
        font-weight: 400;
    }

    .promoOfferBadge {
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        flex-shrink: 0;
        white-space: nowrap;
        border: 0.5px solid transparent;
        font-family: "Rubik", sans-serif;
    }

    /* Green */
    .promoOfferCard--green .promoOfferAccent {
        background: #1D9E75;
    }

    .promoOfferCard--green .promoOfferIcon {
        background: #E1F5EE;
    }

    .promoOfferCard--green .promoOfferThreshold {
        color: #085041;
    }

    .promoOfferCard--green .promoOfferBadge {
        background: #E1F5EE;
        color: #085041;
        border-color: #9FE1CB;
    }

    /* Amber */
    .promoOfferCard--amber .promoOfferAccent {
        background: #BA7517;
    }

    .promoOfferCard--amber .promoOfferIcon {
        background: #FAEEDA;
    }

    .promoOfferCard--amber .promoOfferThreshold {
        color: #633806;
    }

    .promoOfferCard--amber .promoOfferBadge {
        background: #FAEEDA;
        color: #633806;
        border-color: #FAC775;
    }

    /* Blue */
    .promoOfferCard--blue .promoOfferAccent {
        background: #378ADD;
    }

    .promoOfferCard--blue .promoOfferIcon {
        background: #E6F1FB;
    }

    .promoOfferCard--blue .promoOfferThreshold {
        color: #0C447C;
    }

    .promoOfferCard--blue .promoOfferBadge {
        background: #E6F1FB;
        color: #0C447C;
        border-color: #85B7EB;
    }

    /* Coral */
    .promoOfferCard--coral .promoOfferAccent {
        background: #D85A30;
    }

    .promoOfferCard--coral .promoOfferIcon {
        background: #FAECE7;
    }

    .promoOfferCard--coral .promoOfferThreshold {
        color: #712B13;
    }

    .promoOfferCard--coral .promoOfferBadge {
        background: #FAECE7;
        color: #712B13;
        border-color: #F0997B;
    }

    /* Pink */
    .promoOfferCard--pink .promoOfferAccent {
        background: #D4537E;
    }

    .promoOfferCard--pink .promoOfferIcon {
        background: #FBEAF0;
    }

    .promoOfferCard--pink .promoOfferThreshold {
        color: #72243E;
    }

    .promoOfferCard--pink .promoOfferBadge {
        background: #FBEAF0;
        color: #72243E;
        border-color: #ED93B1;
    }

    /* ==================================Promo Offer style End=====================================*/
</style>
@section('content')
    <section class="category_banner" style="background: #EDEDED;">

        @php
            $backgroundImage = null;
        @endphp

        @if ($backgroundImage)
            <div class="container">
                <div class="gs-breadcrumb-section bg-class" data-background="{{ $backgroundImage }}">
                </div>
            </div>
        @endif

    </section>
    <!-- breadcrumb end -->

    <!-- product wrapper start -->
    <div class="gs-blog-wrapper pt-3" style="background: #ededed">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">

                <div class="col-lg-12 gs-main-blog-wrapper">

                    @php
                        if (request()->input('view_check') == null || request()->input('view_check') == 'grid-view') {
                            $view = 'grid-view';
                        } else {
                            $view = 'list-view';
                        }
                    @endphp

                    @if ($prods->count() == 0)
                        <!-- product nav wrapper for no data found -->
                        <div class="product-nav-wrapper rounded-bottom d-flex justify-content-center ">
                            <h5>@lang('No Product Found')</h5>
                        </div>
                    @else
                        <!-- main content -->
                        <div class="tab-content" id="myTabContent">
                            <!-- product list view start  -->
                            <div class="tab-pane fade show active" id="layout-grid-pane" role="tabpanel" tabindex="0">
                                <div class="row gy-4 gy-lg-5 mt-20">
                                    @foreach ($prods as $product)
                                        @include('includes.frontend.offer_products')
                                    @endforeach
                                </div>
                            </div>
                            <!-- product grid view end  -->
                        </div>
                        {{ $prods->links('includes.frontend.pagination') }}
                    @endif
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="promoOfferWrap">
                                <div class="promoOfferLabel">
                                    🎁 বিশেষ অফার
                                </div>
                                <div class="promoOfferList">

                                    <!-- <div class="promoOfferCard promoOfferCard--green">
                                        <div class="promoOfferAccent"></div>
                                        <div class="promoOfferBody">
                                            <div class="promoOfferIcon">🥔</div>
                                            <div class="promoOfferText">
                                                <div class="promoOfferThreshold">১০০০ টাকার কেনাকাটায়</div>
                                                <div class="promoOfferDesc">২ কেজি তাজা আলু পাবেন</div>
                                            </div>
                                            <div class="promoOfferBadge">বিনামূল্যে</div>
                                        </div>
                                    </div> -->

                                    <div class="promoOfferCard promoOfferCard--amber">
                                        <div class="promoOfferAccent"></div>
                                        <div class="promoOfferBody">
                                            <div class="promoOfferIcon">🥩</div>
                                            <div class="promoOfferText">
                                                <div class="promoOfferThreshold">১৫০০ টাকার কেনাকাটায়</div>
                                                <div class="promoOfferDesc">গরুর মাংসের মসলা পাবেন</div>
                                            </div>
                                            <div class="promoOfferBadge">মাত্র ১ ৳</div>
                                        </div>
                                    </div>

                                    <!-- <div class="promoOfferCard promoOfferCard--blue">
                                        <div class="promoOfferAccent"></div>
                                        <div class="promoOfferBody">
                                            <div class="promoOfferIcon">🥚</div>
                                            <div class="promoOfferText">
                                                <div class="promoOfferThreshold">২০০০ টাকার বেশি কেনাকাটায়</div>
                                                <div class="promoOfferDesc">১ ডজন ডিম পাবেন</div>
                                            </div>
                                            <div class="promoOfferBadge">মাত্র ১ ৳</div>
                                        </div>
                                    </div>

                                    <div class="promoOfferCard promoOfferCard--coral">
                                        <div class="promoOfferAccent"></div>
                                        <div class="promoOfferBody">
                                            <div class="promoOfferIcon">🛢️</div>
                                            <div class="promoOfferText">
                                                <div class="promoOfferThreshold">২৫০০ টাকার বেশি কেনাকাটায়</div>
                                                <div class="promoOfferDesc">১ লিটার সয়াবিন তেল পাবেন</div>
                                            </div>
                                            <div class="promoOfferBadge">মাত্র ১ ৳</div>
                                        </div>
                                    </div>

                                    <div class="promoOfferCard promoOfferCard--pink">
                                        <div class="promoOfferAccent"></div>
                                        <div class="promoOfferBody">
                                            <div class="promoOfferIcon">🛒</div>
                                            <div class="promoOfferText">
                                                <div class="promoOfferThreshold">৫০০০ টাকার কেনাকাটায়</div>
                                                <div class="promoOfferDesc">২ লিটার সয়াবিন তেল পাবেন</div>
                                            </div>
                                            <div class="promoOfferBadge">মাত্র ২ ৳</div>
                                        </div> -->
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="text-center my-3">
                        <a href="{{ route('front.index') }}" class="btn btn-primary align-items-center"> এখনি কেনা কাটা শুরু করুন </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- product wrapper end -->
@endsection
