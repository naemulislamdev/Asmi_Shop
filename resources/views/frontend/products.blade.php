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
    height: 295px;
}
  @media (min-width: 1500px) {
        .bg-class {
            background-size: cover !important;
            background-position: center;
            background-repeat: no-repeat;
        }
    }
  @media (max-width: 1200px) {
        .bg-class {
            background-size: contain !important;
            background-position: center;
            background-repeat: no-repeat;
            object-fit: contain !important;
        }
    }
    @media (max-width: 992px) {
        .gs-breadcrumb-section {
            height: 166px;
        }
        .productBannerContainer {
            padding: 0 !important;
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
    /* Breadcumb style start */

    .custom-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        font-size: 14px;
        background: transparent;
        padding: 10px 15px;
        border-radius: 8px;
    }

    /* links */
    .custom-breadcrumb a {
        color: #1598a7;
        text-decoration: none;
        transition: 0.3s;
    }

    .custom-breadcrumb a:hover {
        color: #007bff;
    }

    /* separator icon */
    .custom-breadcrumb .separator {
        margin: 0 8px;
        color: #adb5bd;
        font-size: 12px;
    }

    /* active item */
    .custom-breadcrumb .active {
        color: #212529;
        font-weight: 600;
    }

    /* optional: spacing fix for mobile */
    @media (max-width: 576px) {
        .custom-breadcrumb {
            font-size: 13px;
            padding: 8px 10px;
        }
    }
</style>
@endsection
@section('content')
        
     <section class="category_banner" style="background: #EDEDED;">

        @php
            $backgroundImage = null;

            if (!empty($childcat->banner)) {
                $backgroundImage = asset('assets/images/childcategories/' . $childcat->banner);
            } elseif (!empty($subcat->banner)) {
                $backgroundImage = asset('assets/images/subcategories/' . $subcat->banner);
            } elseif (!empty($cat->photo)) {
                $backgroundImage = asset('assets/images/categories/' . $cat->photo);
            }
        @endphp

        @if ($backgroundImage)
            <div class="container productBannerContainer px-0 px-lg-2">
                <div class="gs-breadcrumb-section  bg-class rounded-b" data-background="{{ $backgroundImage }}">
                </div>
            </div>
        @endif

    </section>
    <!-- breadcrumb end -->

    <!-- product wrapper start -->
    <div class="gs-blog-wrapper pt-3" style="background: #ededed">
        <div class="container">
            
                    <nav class="custom-breadcrumb mb-2 mb-lg-0">
                        <a href="{{ url('/') }}">Home</a>


                        @if (!empty($childcat->name))
                            <span class="separator"><i class="fa fa-chevron-right"></i></span>
                            <a href="{{ route('front.category', $cat->slug) }}">{{ $cat->name }}</a>

                            @if (!empty($subcat->name))
                                <span class="separator"><i class="fa fa-chevron-right"></i></span>
                                <a href="{{ route('front.category', [$cat->slug, $subcat->slug]) }}">
                                    {{ $subcat->name }}
                                </a>
                            @endif

                            <span class="separator"><i class="fa fa-chevron-right"></i></span>
                            <span class="active">{{ $childcat->name }}</span>
                        @elseif (!empty($subcat->name))
                            <span class="separator"><i class="fa fa-chevron-right"></i></span>
                            <a href="{{ route('front.category', $cat->slug) }}">{{ $cat->name }}</a>

                            <span class="separator"><i class="fa fa-chevron-right"></i></span>
                            <span class="active">{{ $subcat->name }}</span>
                        @elseif (!empty($cat->name))
                            <span class="separator"><i class="fa fa-chevron-right"></i></span>
                            <span class="active">{{ $cat->name }}</span>
                        @endif
                    </nav>
                    <h1 class="text-center h2 mb-3">
                        @if (!empty($childcat->name))
                            {{ $childcat->name }}
                        @elseif(!empty($subcat->name))
                            {{ $subcat->name }}
                        @elseif(!empty($cat->name))
                            {{ $cat->name }}
                        @endif
                    </h1>
            <div class="row flex-column-reverse flex-lg-row">

                <div class="col-lg-12 gs-main-blog-wrapper px-0">

                    @php
                        if (request()->input('view_check') == null || request()->input('view_check') == 'grid-view') {
                            $view = 'grid-view';
                        } else {
                            $view = 'list-view';
                        }
                    @endphp


                    {{-- <!-- product nav wrapper -->
                    <div class=" product-nav-wrapper mb-3 rounded-bottom">
                        <h5>@lang('Total Products Found:') {{ $prods->count() }}</h5>
                    </div> --}}



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
                                <div class="row gy-4 justify-content-center gx-4 mt-20">
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

    <input type="hidden" id="update_min_price" value="">
    <input type="hidden" id="update_max_price" value="">
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
                '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}';

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
                    '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}';
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
