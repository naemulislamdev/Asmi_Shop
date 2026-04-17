@extends('layouts.front')

<style>
    .offersAccordion .accordion-button:hover {
        z-index: 2;
        border-radius: 6px 6px 0 0 !important;
    }

    .offersAccordion .accordion-item {
        border-radius: 6px !important;
    }

    .offersAccordion .accordion-item .accordion-header {
        border-radius: 6px 6px 0 0 !important;
    }

    .offersAccordion .accordion-item .accordion-collapse {
        border-radius: 0 0 6px 6px;
    }

    /* implement style */
    .offersAccordion .accordion-item {
        border: none;
        margin-bottom: 10px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .offersAccordion .accordion-button {
        font-weight: 500;
        padding: 14px 18px;
        background: #f8f9fa;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: none;
    }

    /* Hover effect */
    .offersAccordion .accordion-button:hover {
        background: #f1f3f5;
    }

    /* Active (opened) state - no blue */
    .offersAccordion .accordion-button:not(.collapsed) {
        background: #f8f9fa;
        color: #000;
        box-shadow: none;
    }

    /* Remove default Bootstrap blue focus */
    .offersAccordion .accordion-button:focus {
        box-shadow: none;
        border-color: transparent;
    }

    /* Arrow rotation */
    .offersAccordion .accordion-button::after {
        transition: transform 0.3s ease;
    }

    .offersAccordion .accordion-button:not(.collapsed)::after {
        transform: rotate(180deg);
    }

    /* Image alignment */
    .offersAccordion .accordion-button img {
        width: 40px;
        height: auto;
        object-fit: cover;
        border-radius: 6px;
    }

    /* Smooth collapse */
    .offersAccordion .accordion-collapse {
        transition: all 0.3s ease;
    }
</style>

@section('content')
    <!-- product wrapper start -->
    <div class="gs-blog-wrapper offersAccordion pt-5" style="background: #ededed">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="accordion" id="accordionExample">
                        @foreach ($offerCats as $offerCat)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $offerCat->id }}">
                                    {{-- <a href="{{ route('front.offers', $offerCat->slug) }}">
                                        {{ $offerCat->name }}
                                    </a> --}}
                                    <div data-bs-toggle="collapse" data-bs-target="#collapse{{ $offerCat->id }}"
                                        aria-expanded="true" aria-controls="collapse{{ $offerCat->id }}"
                                        class="accordion-button" type="button">
                                        <a onclick="window.location.href=this.href" class="d-inline-block"
                                            href="{{ route('front.offers', $offerCat->slug) }}">
                                            <img class="rounded ms-3" style="width: 50px"
                                                src="{{ asset('assets/images/categories') }}/{{ $offerCat->image }}"
                                                alt="{{ $offerCat->name }}">
                                            <span class="d-inline-block ms-2 ps-2 ml-2 pl-2">{{ $offerCat->name }}</span>
                                        </a>

                                    </div>
                                </h2>
                                <div id="collapse{{ $offerCat->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $offerCat->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row flex-column-reverse flex-lg-row">
                                            <div class="col-12 col-lg-12 gs-main-blog-wrapper">

                                                @php
                                                    if (
                                                        request()->input('view_check') == null ||
                                                        request()->input('view_check') == 'grid-view'
                                                    ) {
                                                        $view = 'grid-view';
                                                    } else {
                                                        $view = 'list-view';
                                                    }
                                                @endphp

                                                <!-- product nav wrapper -->
                                                <div class=" product-nav-wrapper mb-3">
                                                    <h5>@lang('Total Products Found:') {{ $offerCat->offerProducts->count() }}</h5>
                                                </div>

                                                @if ($offerCat->offerProducts->count() == 0)
                                                    <!-- product nav wrapper for no data found -->
                                                    <div class="product-nav-wrapper d-flex justify-content-center">
                                                        <h5>@lang('No Product Found')</h5>
                                                    </div>
                                                @else
                                                    <!-- main content -->
                                                    <div class="tab-content" id="myTabContent">
                                                        <div class="tab-pane fade show active" id="ex-product-1-pane"
                                                            role="tabpanel" aria-labelledby="ex-product-1" tabindex="0">
                                                            <div class="row gy-4">
                                                                @foreach ($offerCat->offerProducts as $product)
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
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- product wrapper end -->
@endsection


@section('script')
    <script>
        $(document).on("click", "#price_filter", function() {
            let amountString = $("#amount").val();

            amountString = amountString.replace(/\$/g, '');

            // Split the string into two amounts
            let amounts = amountString.split('-');

            // Trim whitespace from each amount
            let amount1 = amounts[0].trim();
            let amount2 = amounts[1].trim();


            $("#update_min_price").val(amount1);
            $("#update_max_price").val(amount2);

            filter();

        });

        // when dynamic attribute changes
        $(".attribute-input, #sortby, #pageby").on('change', function() {
            $(".ajax-loader").show();
            filter();
        });

        function filter() {
            let filterlink =
                '{{ route('front.offers', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}';

            let params = new URLSearchParams();


            $(".attribute-input").each(function() {
                if ($(this).is(':checked')) {
                    params.append($(this).attr('name'), $(this).val());
                }
            });

            if ($("#sortby").val() != '') {
                params.append($("#sortby").attr('name'), $("#sortby").val());
            }

            if ($("#start_value").val() != '') {
                params.append($("#start_value").attr('name'), $("#start_value").val());
            }

            let check_view = $('.check_view.active').data('shopview');

            if (check_view) {
                params.append('view_check', check_view);
            }

            if ($("#update_min_price").val() != '') {
                params.append('min', $("#update_min_price").val());
            }
            if ($("#update_max_price").val() != '') {
                params.append('max', $("#update_max_price").val());
            }

            filterlink += '?' + params.toString();

            console.log(filterlink);
            location.href = filterlink;
        }

        // append parameters to pagination links
        function addToPagination() {
            $('ul.pagination li a').each(function() {
                let url = $(this).attr('href');
                let queryString = '?' + url.split('?')[1]; // "?page=1234...."
                let urlParams = new URLSearchParams(queryString);
                let page = urlParams.get('page'); // value of 'page' parameter

                let fullUrl =
                    '{{ route('front.offers', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}';
                let params = new URLSearchParams();

                $(".attribute-input").each(function() {
                    if ($(this).is(':checked')) {
                        params.append($(this).attr('name'), $(this).val());
                    }
                });

                if ($("#sortby").val() != '') {
                    params.append('sort', $("#sortby").val());
                }


                if ($("#pageby").val() != '') {
                    params.append('pageby', $("#pageby").val());
                }

                params.append('page', page);

                $(this).attr('href', fullUrl + '?' + params.toString());
            });
        }
    </script>

    <script type="text/javascript">
        (function($) {
            "use strict";
            $(function() {
                const start_value = $("#start_value").val();
                const end_value = $("#end_value").val();
                const max_value = $("#max_value").val();

                $("#slider-range").slider({
                    range: true,
                    min: 0,
                    max: max_value,
                    values: [start_value, end_value],
                    step: 10,
                    slide: function(event, ui) {
                        $("#amount").val("৳" + ui.values[0] + " - ৳" + ui.values[1]);
                    },
                });
                $("#amount").val(
                    "৳" +
                    $("#slider-range").slider("values", 0) +
                    " - ৳" +
                    $("#slider-range").slider("values", 5000)
                );
            });

        })(jQuery);
    </script>
@endsection
