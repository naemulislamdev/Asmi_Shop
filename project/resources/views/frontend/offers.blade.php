@extends('layouts.front')

@section('content')
    <!-- product wrapper start -->
    <div class="gs-blog-wrapper" style="background: #ededed">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">
                <div class="col-12 col-lg-12 gs-main-blog-wrapper">

                    @php
                        if (request()->input('view_check') == null || request()->input('view_check') == 'grid-view') {
                            $view = 'grid-view';
                        } else {
                            $view = 'list-view';
                        }
                    @endphp

                    <!-- product nav wrapper -->
                    <div class=" product-nav-wrapper mb-3">
                        <h5>@lang('Total Products Found:') {{ $prods->count() }}</h5>
                    </div>

                    @if ($prods->count() == 0)
                        <!-- product nav wrapper for no data found -->
                        <div class="product-nav-wrapper d-flex justify-content-center">
                            <h5>@lang('No Product Found')</h5>
                        </div>
                    @else
                        <!-- main content -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="ex-product-1-pane" role="tabpanel"
                                aria-labelledby="ex-product-1" tabindex="0">
                                <div class="row gy-4">
                                    @foreach ($prods as $product)
                                        @include('includes.frontend.home_product')
                                    @endforeach
                                </div>
                            </div>
                            <!-- product grid view end  -->
                        </div>
                        {{ $prods->links('includes.frontend.pagination') }}
                    @endif
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
