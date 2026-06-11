@extends('layouts.front')
@section('css')
<style>
    .gs-blog-wrapper {
        padding: 0 !important;
    }

    .bg-class {
        background-size: contain !important;
        background-position: center;
        -o-object-fit: cover;
        object-fit: contain;
    }

    .gs-breadcrumb-section {
        padding: 0 !important;
        position: relative;
        height: 328px;
    }

    @media (max-width: 992px) {
        .gs-breadcrumb-section {
            height: 166px;
        }
    }

    @media (max-width: 768px) {
        .gs-breadcrumb-section {
            height: 160px;
        }

        .bg-class {
            background-size: cover !important;
            background-position: center;
            -o-object-fit: cover;
            object-fit: contain;
        }
    }

    @media (max-width: 576px) {
        .gs-breadcrumb-section {
            height: 100px;
        }

        .bg-class {
            background-size: contain !important;
            background-position: center;
            object-fit: contain;
        }
    }
</style>
@endsection
@section('content')

<section class="category_banner" style="background: #EDEDED;">
        @php
            $backgroundImage = asset('assets/images/promo-offers/Pusti-Banner.jpeg');
        @endphp
        <div class="container">
            <div class="gs-breadcrumb-section bg-class" data-background="{{ $backgroundImage }}">
            </div>
        </div>

    </section>
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
                                <div class="row gy-4 gy-lg-5 mt-20 mb-2">
                                    @foreach ($prods as $product)
                                        @include('includes.frontend.home_product')
                                    @endforeach
                                </div>
                            </div>
                            <!-- product grid view end  -->
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- product wrapper end -->

    <input type="hidden" id="update_min_price" value="">
    <input type="hidden" id="update_max_price" value="">
@endsection
