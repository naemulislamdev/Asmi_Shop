@extends('layouts.vendor')
@section('css')
    <link href="{{ asset('assets/admin/css/jquery.Jcrop.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/Jcrop-style.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="gs-vendor-outlet">
        <!-- breadcrumb start  -->
        <div class="gs-vendor-breadcrumb has-mb">
            <div class="gs-deposit-title ms-0 d-flex align-items-center gap-4">
                <a href="{{ route('vendor-prod-index') }}" class="back-btn">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <h4>@lang('Edit Product')</h4>
            </div>
            <ul class="breadcrumb-menu">
                <li>
                    <a href="{{ route('vendor.dashboard') }}" class="text-capitalize">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="#4C3533" class="home-icon-vendor-panel-breadcrumb">
                            <path
                                d="M9 21V13.6C9 13.0399 9 12.7599 9.109 12.546C9.20487 12.3578 9.35785 12.2049 9.54601 12.109C9.75993 12 10.04 12 10.6 12H13.4C13.9601 12 14.2401 12 14.454 12.109C14.6422 12.2049 14.7951 12.3578 14.891 12.546C15 12.7599 15 13.0399 15 13.6V21M2 9.5L11.04 2.72C11.3843 2.46181 11.5564 2.33271 11.7454 2.28294C11.9123 2.23902 12.0877 2.23902 12.2546 2.28295C12.4436 2.33271 12.6157 2.46181 12.96 2.72L22 9.5M4 8V17.8C4 18.9201 4 19.4802 4.21799 19.908C4.40974 20.2843 4.7157 20.5903 5.09202 20.782C5.51985 21 6.0799 21 7.2 21H16.8C17.9201 21 18.4802 21 18.908 20.782C19.2843 20.5903 19.5903 20.2843 19.782 19.908C20 19.4802 20 18.9201 20 17.8V8L13.92 3.44C13.2315 2.92361 12.8872 2.66542 12.5091 2.56589C12.1754 2.47804 11.8246 2.47804 11.4909 2.56589C11.1128 2.66542 10.7685 2.92361 10.08 3.44L4 8Z"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vendor.dashboard') }}" class="text-capitalize">
                        @lang('Dashboard')
                    </a>
                </li>
                <li>
                    <a href="{{ route('vendor-prod-index') }}" class="text-capitalize"> @lang('Products') </a>
                </li>
                <li>
                    <a href="#" class="text-capitalize"> @lang('Edit Product') </a>
                </li>
            </ul>
        </div>
        <!-- breadcrumb end -->

        <!-- add product form start  -->
        <form class="row gy-3 gy-lg-4 add-product-form" id="myForm"
            action="{{ route('vendor-prod-catalog-update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="Physical">
            <!-- inputes of physical product start  -->
            <div class="col-12 col-lg-8 physical-product-inputes-wrapper show">
                <div class="form-group">
                    <!-- Product Name -->
                    <div class="input-label-wrapper">
                        <label>@lang('Product Name* (In Any Language)')</label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Enter Product Name') "
                            value="{{ $data->name }}">
                    </div>
                    <!-- Product SkU -->
                    <div class="input-label-wrapper">
                        <label>@lang('Product SkU*')</label>
                        <input type="text" class="form-control" name="sku" placeholder="@lang('Enter Product SKU')"
                            value="{{ Str::random(3) . substr(time(), 6, 8) . Str::random(3) }}">
                    </div>
                    <!-- Category -->
                    <div class="input-label-wrapper">
                        <label>Category*</label>
                        <div class="dropdown-container">
                            <select class="form-control nice-select form__control " name="category_id" id="cat">
                                <option value="" disabled selected>
                                    @lang('Select Category')
                                </option>
                                @foreach ($cats as $cat)
                                    <option data-href="{{ route('vendor-subcat-load', $cat->id) }}"
                                        value="{{ $cat->id }}"
                                        {{ $cat->id == $data->category_id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                                <!-- Add more options here if needed -->
                            </select>
                        </div>
                    </div>
                    <!-- Sub Category -->
                    <div class="input-label-wrapper">
                        <label>@lang('Sub Category*')</label>
                        <div class="dropdown-container">
                            <select class="form-control nice-select form__control subcategory" name="subcategory_id"
                                id="subcat">
                                <option value="" disabled selected>
                                    @lang('Select Sub Category')
                                </option>
                                @if ($data->subcategory_id == null)
                                    @foreach ($data->category->subs as $sub)
                                        <option data-href="{{ route('vendor-childcat-load', $sub->id) }}"
                                            value="{{ $sub->id }}">{{ $sub->name }}</option>
                                    @endforeach
                                @else
                                    @foreach ($data->category->subs as $sub)
                                        <option data-href="{{ route('vendor-childcat-load', $sub->id) }}"
                                            value="{{ $sub->id }}"
                                            {{ $sub->id == $data->subcategory_id ? 'selected' : '' }}>
                                            {{ $sub->name }}</option>
                                    @endforeach
                                @endif
                                <!-- Add more options here if needed -->
                            </select>
                        </div>
                    </div>
                    <!-- Child Category -->
                    <div class="input-label-wrapper">
                        <label>@lang('Child Category*')</label>
                        <div class="dropdown-container">
                            <select class="form-control nice-select form__control childcat" name="childcategory_id"
                                id="childcat" {{ $data->subcategory_id == null ? 'disabled' : '' }}>
                                <option value="" disabled selected>
                                    @lang('Select Child Category')
                                </option>
                                @if ($data->subcategory_id != null)
                                    @if ($data->childcategory_id == null)
                                        @foreach ($data->subcategory->childs as $child)
                                            <option value="{{ $child->id }}">{{ $child->name }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($data->subcategory->childs as $child)
                                            <option value="{{ $child->id }} "
                                                {{ $child->id == $data->childcategory_id ? 'selected' : '' }}>
                                                {{ $child->name }}</option>
                                        @endforeach
                                    @endif
                                @endif
                                <!-- Add more options here if needed -->
                            </select>
                        </div>
                    </div>


                    @php
                        $selectedAttrs = json_decode($data->attributes, true);
                    @endphp

                    {{-- Attributes of category starts --}}
                    <div id="catAttributes">
                        @php
                            $catAttributes = !empty($data->category->attributes) ? $data->category->attributes : '';
                        @endphp
                        @if (!empty($catAttributes))
                            @foreach ($catAttributes as $catAttribute)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="left-area">
                                            <h4 class="heading">{{ $catAttribute->name }} *</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($catAttribute->attribute_options as $optionKey => $option)
                                            @php
                                                $inName = $catAttribute->input_name;
                                                $checked = 0;
                                            @endphp
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                            id="{{ $catAttribute->input_name }}{{ $option->id }}"
                                                            name="{{ $catAttribute->input_name }}[]"
                                                            value="{{ $option->name }}"
                                                            class="custom-control-input attr-checkbox"
                                                            @if (is_array($selectedAttrs) && array_key_exists($catAttribute->input_name, $selectedAttrs)) @if (is_array($selectedAttrs["$inName"]['values']) && in_array($option->name, $selectedAttrs["$inName"]['values']))
                                                    checked
                                                    @php
                                                        $checked = 1;
                                                    @endphp @endif
                                                            @endif
                                                        >
                                                        <label class="custom-control-label"
                                                            for="{{ $catAttribute->input_name }}{{ $option->id }}">{{ $option->name }}</label>
                                                    </div>
                                                </div>

                                                <div
                                                    class="col-lg-7 {{ $catAttribute->price_status == 0 ? 'd-none' : '' }}">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            +
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="price-container">
                                                                <span class="price-curr">{{ $sign->sign }}</span>
                                                                <input type="text" class="input-field price-input"
                                                                    id="{{ $catAttribute->input_name }}{{ $option->id }}_price"
                                                                    data-name="{{ $catAttribute->input_name }}_price[]"
                                                                    placeholder="@lang('0.00 (Additional Price)')"
                                                                    value="{{ !empty($selectedAttrs["$inName"]['prices'][$i]) && $checked == 1
                                                                        ? round($selectedAttrs["$inName"]['prices'][$i] * $sign->value, 2)
                                                                        : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                if ($checked == 1) {
                                                    $i++;
                                                }
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- Attributes of category ends --}}

                    {{-- Attributes of subcategory starts --}}
                    <div id="subcatAttributes">
                        @php
                            $subAttributes = !empty($data->subcategory->attributes)
                                ? $data->subcategory->attributes
                                : '';
                        @endphp
                        @if (!empty($subAttributes))
                            @foreach ($subAttributes as $subAttribute)
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <div class="left-area">
                                            <h4 class="heading">{{ $subAttribute->name }} *</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($subAttribute->attribute_options as $option)
                                            @php
                                                $inName = $subAttribute->input_name;
                                                $checked = 0;
                                            @endphp

                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="custom-control custom-checkbox">

                                                        <input type="checkbox"
                                                            id="{{ $subAttribute->input_name }}{{ $option->id }}"
                                                            name="{{ $subAttribute->input_name }}[]"
                                                            value="{{ $option->name }}"
                                                            class="custom-control-input attr-checkbox"
                                                            @if (is_array($selectedAttrs) && array_key_exists($subAttribute->input_name, $selectedAttrs)) @php
                                                $inName = $subAttribute->input_name;
                                                @endphp
                                                @if (is_array($selectedAttrs["$inName"]['values']) && in_array($option->name, $selectedAttrs["$inName"]['values']))
                                                    checked
                                                    @php
                                                    $checked = 1;
                                                    @endphp @endif
                                                            @endif
                                                        >

                                                        <label class="custom-control-label"
                                                            for="{{ $subAttribute->input_name }}{{ $option->id }}">{{ $option->name }}</label>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-lg-7 {{ $subAttribute->price_status == 0 ? 'd-none' : '' }}">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            +
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="price-container">
                                                                <span class="price-curr">{{ $sign->sign }}</span>
                                                                <input type="text" class="input-field price-input"
                                                                    id="{{ $subAttribute->input_name }}{{ $option->id }}_price"
                                                                    data-name="{{ $subAttribute->input_name }}_price[]"
                                                                    placeholder="@lang('0.00 (Additional Price)')"
                                                                    value="{{ !empty($selectedAttrs["$inName"]['prices'][$i]) && $checked == 1
                                                                        ? round($selectedAttrs["$inName"]['prices'][$i] * $sign->value, 2)
                                                                        : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                if ($checked == 1) {
                                                    $i++;
                                                }
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- Attributes of subcategory ends --}}

                    {{-- Attributes of child category starts --}}
                    <div id="childcatAttributes">
                        @php
                            $childAttributes = !empty($data->childcategory->attributes)
                                ? $data->childcategory->attributes
                                : '';
                        @endphp
                        @if (!empty($childAttributes))
                            @foreach ($childAttributes as $childAttribute)
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <div class="left-area">
                                            <h4 class="heading">{{ $childAttribute->name }} *</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($childAttribute->attribute_options as $optionKey => $option)
                                            @php
                                                $inName = $childAttribute->input_name;
                                                $checked = 0;
                                            @endphp
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox"
                                                            id="{{ $childAttribute->input_name }}{{ $option->id }}"
                                                            name="{{ $childAttribute->input_name }}[]"
                                                            value="{{ $option->name }}"
                                                            class="custom-control-input attr-checkbox"
                                                            @if (is_array($selectedAttrs) && array_key_exists($childAttribute->input_name, $selectedAttrs)) @php
                                                $inName = $childAttribute->input_name;
                                                @endphp
                                                @if (is_array($selectedAttrs["$inName"]['values']) && in_array($option->name, $selectedAttrs["$inName"]['values']))
                                                    checked
                                                    @php
                                                    $checked = 1;
                                                    @endphp @endif
                                                            @endif
                                                        >

                                                        <label class="custom-control-label"
                                                            for="{{ $childAttribute->input_name }}{{ $option->id }}">{{ $option->name }}</label>
                                                    </div>
                                                </div>


                                                <div
                                                    class="col-lg-7 {{ $childAttribute->price_status == 0 ? 'd-none' : '' }}">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            +
                                                        </div>
                                                        <div class="col-10">
                                                            <div class="price-container">
                                                                <span class="price-curr">{{ $sign->sign }}</span>
                                                                <input type="text" class="input-field price-input"
                                                                    id="{{ $childAttribute->input_name }}{{ $option->id }}_price"
                                                                    data-name="{{ $childAttribute->input_name }}_price[]"
                                                                    placeholder="@lang('0.00 (Additional Price)')"
                                                                    value="{{ !empty(
                                                                        $selectedAttrs[
                                                                            "
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $inName"
                                                                        ]['prices'][$i]
                                                                    ) && $checked == 1
                                                                        ? round($selectedAttrs["$inName"]['prices'][$i] * $sign->value, 2)
                                                                        : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                if ($checked == 1) {
                                                    $i++;
                                                }
                                            @endphp
                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- Attributes of child category ends --}}










                    <!-- Allow Product Condition Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_child-category" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_child-category">
                        <input type="checkbox" id="allow-product-condition"
                            {{ $data->product_condition != 0 ? 'checked' : '' }} name="product_condition_check"
                            value="1">
                        <label class="icon-label check-box-label" for="allow-product-condition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-product-condition">@lang('Allow Product Condition')</label>
                    </div>
                    <!-- Child Category -->
                    <div class="input-label-wrapper collapse {{ $data->product_condition != 0 ? 'show' : '' }}"
                        id="show_child-category">
                        <label for="child-category-select">@lang('Product Condition*')</label>
                        <div class="dropdown-container">
                            <select id="child-category-select" class="form-control nice-select form__control"
                                name="product_condition">
                                <option value="2">{{ __('New') }}</option>
                                <option value="1">{{ __('Used') }}</option>
                                <!-- Add more options here if needed -->
                            </select>
                        </div>
                    </div>



                    <!-- Allow Product Preorder Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_product-preorder" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_product-preorder">
                        <input type="checkbox" id="allow-product-preorder" {{ $data->preordered != 0 ? 'checked' : '' }}
                            name="preordered_check" value="1">
                        <label class="icon-label check-box-label" for="allow-product-preorder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-product-preorder">@lang('Allow Product
                                                                                                                            Preorder')</label>
                    </div>
                    <!-- Product Preorder -->
                    <div class="input-label-wrapper collapse  {{ $data->preordered != 0 ? 'show' : '' }}"
                        id="show_product-preorder">
                        <label for="product-preorder-select">@lang('Product Preorder*')</label>
                        <div class="dropdown-container">
                            <select id="product-preorder-select" class="form-control nice-select form__control"
                                name="preordered">
                                <option value="1">{{ __('Sale') }}</option>
                                <option value="2">{{ __('Preordered') }}</option>
                                <!-- Add more options here if needed -->
                            </select>
                        </div>
                    </div>





                    <!-- Allow Minimum Order Qty Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_minimum-order" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_minimum-order">
                        <input type="checkbox" {{ $data->minimum_qty != null ? 'checked' : '' }} id="allow-minimum-order"
                            name="minimum_qty_check" value="1">
                        <label class="icon-label check-box-label" for="allow-minimum-order">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-minimum-order">@lang('Allow Minimum Order Qty')</label>
                    </div>
                    <!-- Product Minimum Order Qty -->
                    <div class="input-label-wrapper collapse {{ $data->minimum_qty != null ? 'show' : '' }}"
                        id="show_minimum-order">
                        <label>@lang('Product Minimum Order Qty*')</label>
                        <input type="text" class="form-control" name="minimum_qty" placeholder="@lang('Minimum Order Qty') "
                            value="{{ $data->minimum_qty }}">
                    </div>

                    <!-- Allow Estimated Shipping Time Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_estimated-shipping-time" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_estimated-shipping-time">
                        <input type="checkbox" id="allow-estimated-shipping-time" name="shipping_time_check"
                            value="1" {{ $data->ship != null ? 'checked' : '' }}>
                        <label class="icon-label check-box-label" for="allow-estimated-shipping-time">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-estimated-shipping-time">@lang('Allow Estimated Shipping Time')</label>
                    </div>
                    <!-- Estimated Shipping Time -->
                    <div class="input-label-wrapper collapse {{ $data->ship != null ? 'show' : '' }}"
                        id="show_estimated-shipping-time">
                        <label>@lang('Estimated Shipping Time*')</label>
                        <input type="text" class="form-control" name="ship" placeholder=" @lang('Estimated Shipping Time')"
                            value="{{ $data->ship == null ? '' : $data->ship }}">
                    </div>


                    <!-- Allow Product Whole Sell Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_product-whole-sell" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_product-whole-sell">
                        <input type="checkbox" {{ !empty($data->whole_sell_qty) ? 'checked' : '' }} name="whole_check"
                            id="allow-product-whole-sell">
                        <label class="icon-label check-box-label" for="allow-product-whole-sell">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-product-whole-sell">@lang('Allow Product Whole
                                                                                                                            Sell')</label>
                    </div>
                    <!-- Product Whole Sell -->
                    <div class="input-label-wrapper collapse {{ !empty($data->whole_sell_qty) ? 'show' : '' }}"
                        id="show_product-whole-sell">
                        <label>@lang('Allow Product Whole Sell')</label>

                        <div class="d-flex flex-column g-4 gap-4" id="whole-section">
                            @if (!empty($data->whole_sell_qty))

                                @foreach ($data->whole_sell_qty as $key => $data1)
                                    <div class="row row-cols-1 row-cols-md-3 gy-4 postion-relative">
                                        <div class="col">
                                            <input type="text" class="form-control" name="whole_sell_qty[]"
                                                placeholder="@lang('Enter Quantity') "
                                                value="{{ $data->whole_sell_qty[$key] }}">
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" name="whole_sell_discount[]"
                                                placeholder="@lang('Enter Discount Percentage') "
                                                value="{{ $data->whole_sell_discount[$key] }}">
                                        </div>
                                        <button type="button" class="delete-item-btn text-danger remove_whole_sell"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                @endforeach
                            @else
                                <div class="row row-cols-1 row-cols-md-3 gy-4 postion-relative">
                                    <div class="col">
                                        <input type="text" class="form-control" name="whole_sell_qty[]"
                                            placeholder="@lang('Enter Quantity') ">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name="whole_sell_discount[]"
                                            placeholder="@lang('Enter Discount Percentage') ">
                                    </div>
                                    <button type="button" class="delete-item-btn text-danger remove_whole_sell"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </div>
                            @endif
                        </div>

                        <div class="col-12 col-md-12 d-flex justify-content-end mt-4">
                            <button class="template-btn outline-btn" id="whole-btn"
                                type="button">+@lang('Add More
                                                                                                                                                                Field')</button>
                        </div>

                    </div>


                    <!-- Allow Product Measurement Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_product-measurement" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_product-measurement">
                        <input type="checkbox" {{ $data->measure == null ? '' : 'checked' }}
                            id="allow-product-measurement" name="measure_check">
                        <label class="icon-label check-box-label" for="allow-product-measurement">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-product-measurement">@lang('Allow Product
                                                                                                                            Measurement')</label>
                    </div>
                    <!-- Product Measurement -->
                    <div class="input-label-wrapper collapse {{ $data->measure != null ? 'show' : '' }}"
                        id="show_product-measurement">
                        <label for="product-measurement-select">@lang('Product Measurement*')</label>
                        <div class="dropdown-container">
                            <select id="product-measurement-select" name="measure"
                                class="form-control nice-select form__control">
                                <option value="">{{ __('None') }}</option>
                                <option value="Gram">{{ __('Gram') }}</option>
                                <option value="Kilogram">{{ __('Kilogram') }}</option>
                                <option value="Litre">{{ __('Litre') }}</option>
                                <option value="Pound">{{ __('Pound') }}</option>
                                <option value="Custom">{{ __('Custom') }}</option>
                                <!-- Add more options here if needed -->
                            </select>
                        </div>
                    </div>



                    <!-- Allow Product Colors Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_allow-product-colors" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_allow-product-colors">
                        <input type="checkbox" {{ !is_array($data->color_all) ? '' : ' checked' }} name="color_check"
                            id="allow-allow-product-colors" class="checkclickc">
                        <label class="icon-label check-box-label" for="allow-allow-product-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-allow-product-colors">@lang('Allow Product
                                                                                                                            Colors')</label>
                    </div>
                    <!-- Product Colors -->
                    <div class="input-label-wrapper collapse {{ !is_array($data->color_all) ? '' : 'show' }}"
                        id="show_allow-product-colors">
                        <label>@lang('Product Colors* (Choose Your Favorite
                                                                                                                            Colors)')</label>
                        <div class="row gy-4">
                            <div id="color-section">
                                @if ($data->color_all)
                                    @foreach ($data->color_all as $item)
                                        <div class="col-12 position-relative mt-2">
                                            <input type="text" class="form-control"
                                                placeholder="{{ $item }}">
                                            <input class="h-100 position-absolute top-0 end-0 color-input" type="color"
                                                id="favcolor_1" name="color_all[]" value="{{ $item }}">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12 position-relative">
                                        <input type="text" class="form-control" placeholder="#000000 ">
                                        <input class="h-100 position-absolute top-0 end-0 color-input" type="color"
                                            id="favcolor_1" name="color_all[]" value="#000000">
                                    </div>
                                @endif

                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button class="template-btn outline-btn" id="color-btn"
                                    type="button">+@lang('Add More
                                                                                                                                                                                    Field')</button>
                            </div>
                        </div>

                    </div>

                    <!-- Manage Stock Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_manage-stock" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_manage-stock">
                        <input type="checkbox" id="allow-manage-stock" name="stock_check" value="1"
                            {{ $data->stock_check == 1 ? 'checked' : '' }}>
                        <label class="icon-label check-box-label" for="allow-manage-stock">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-manage-stock">@lang('Manage Stock')</label>
                    </div>

                    <!-- Manage Stock -->
                    <div class="input-label-wrapper collapse {{ $data->stock_check == 1 ? 'show' : '' }}"
                        id="show_manage-stock">

                        <div id="size-section">
                            @if (!empty($data->size))
                                @foreach ($data->size as $key => $size)
                                    <div
                                        class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 align-items-end gx-3 gy-4">
                                        <!-- Size Name -->
                                        <div class="col">
                                            <div class="lebel-box">
                                                <label class="main-label">@lang('Size Name :')</label>
                                                <label class="sub-label">@lang('(eg. S,M,L,XL,3XL,4XL)')</label>
                                            </div>
                                            <input type="text" class="form-control" name="size[]" placeholder=""
                                                value="{{ $size }}">
                                        </div>
                                        <div class="col">
                                            <div class="lebel-box">
                                                <label class="main-label">@lang('Size Qty :')</label>
                                                <label class="sub-label">@lang('(Quantity of this size)')</label>
                                            </div>
                                            <input type="text" class="form-control" name="size_qty[]" placeholder=""
                                                value="{{ $data->size_qty[$key] }}">
                                        </div>
                                        <div class="col">
                                            <div class="lebel-box">
                                                <label class="main-label">@lang('Size Price :')</label>
                                                <label class="sub-label">@lang('(Added with base price)')</label>
                                            </div>
                                            <input type="text" class="form-control" name="size_price[]"
                                                placeholder=""
                                                value="{{ round($data->size_price[$key] * $sign->value, 2) }}">
                                        </div>
                                        <div class="col">
                                            <button type="button" class="btn btn-danger remove_stock">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 align-items-end gx-3 gy-4">
                                    <!-- Size Name -->
                                    <div class="col">
                                        <div class="lebel-box">
                                            <label class="main-label">@lang('Size Name :')</label>
                                            <label class="sub-label">@lang('(eg. S,M,L,XL,3XL,4XL)')</label>
                                        </div>
                                        <input type="text" class="form-control" name="size[]" placeholder="">
                                    </div>
                                    <div class="col">
                                        <div class="lebel-box">
                                            <label class="main-label">@lang('Size Qty :')</label>
                                            <label class="sub-label">@lang('(Quantity of this size)')</label>
                                        </div>
                                        <input type="text" class="form-control" name="size_qty[]" placeholder="">
                                    </div>
                                    <div class="col">
                                        <div class="lebel-box">
                                            <label class="main-label">@lang('Size Price :')</label>
                                            <label class="sub-label">@lang('(Added with base price)')</label>
                                        </div>
                                        <input type="text" class="form-control" name="size_price[]" placeholder="">
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-danger remove_stock">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                            @endif

                        </div>

                        <div class="col-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-end mt-4">
                            <button class="template-btn outline-btn" id="size-btn"
                                type="button">+@lang('Add More')</button>
                        </div>
                    </div>



                    <!-- Product Description -->
                    <div class="input-label-wrapper">
                        <label>@lang('Product Description*')</label>
                        <textarea class="form-control w-100 nic-edit" id="details" name="details" rows="6">{{ $data->details }}</textarea>
                    </div>
                    <!-- Product Buy/Return Policy -->
                    <div class="input-label-wrapper">
                        <label>@lang('Product Buy/Return Policy*')</label>
                        <textarea class="form-control w-100 nic-edit" id="policy" name="policy" rows="6">{{ $data->policy }}</textarea>
                    </div>
                    <!-- Allow Product SEO Checkbox -->
                    <div class="gs-checkbox-wrapper" aria-controls="show_product-seo" role="region"
                        data-bs-toggle="collapse" data-bs-target="#show_product-seo">
                        <input type="checkbox" id="allow-product-seo" name="is_meta" value="1"
                            {{ $data->is_meta == 1 ? 'checked' : '' }}>
                        <label class="icon-label check-box-label" for="allow-product-seo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                fill="none">
                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243" stroke-width="1.6666" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </label>
                        <label class="check-box-label" for="allow-product-seo">@lang('Allow Product SEO')</label>
                    </div>
                    <div class="input-label-wrapper collapse row gy-4 {{ $data->is_meta == 1 ? 'show' : '' }}"
                        id="show_product-seo">
                        <!-- Meta Tags  -->
                        <div class="col-12">
                            <label>@lang('Meta Tags *')</label>
                            <input type="text" class="myTags" id="metatags" name="meta_tag"
                                value="{{ is_array($data->meta_tag) && implode(',', $data->meta_tag) }}" placeholder="">

                        </div>
                        <!-- Meta Description  -->
                        <div class="col-12">
                            <label>@lang('Meta Description *')</label>
                            <textarea class="form-control w-100" placeholder="@lang('Meta Description')" name="meta_description" rows="6">{{ $data->meta_description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- form sidebar start  -->
            <div class="col-12 col-lg-4">
                <div class="add-product-form-sidebar">
                    <div class="form-group">
                        <!-- Feature Image  -->
                        <div class="input-label-wrapper">
                            <label>@lang('Feature Image *')</label>
                            <div class="w-100">
                                <div class="overlayed-img-wrapper">
                                    <div class="span4 cropme text-center" id="landscape"
                                        style="width: 100%; height: 285px; border: 1px dashed #ddd; background: #f1f1f1;">
                                        <a href="javascript:;" id="crop-image" class=" mybtn1" style="">
                                            <i class="icofont-upload-alt"></i>
                                            @lang('Upload Image Here')
                                        </a>
                                    </div>
                                </div>

                                <input type="hidden" id="feature_photo" name="photo" value="{{ $data->photo }}">
                            </div>
                        </div>
                        <!-- Product Gallery Images  -->
                        <div class="input-label-wrapper">
                            <label for="gallery_upload">@lang('Product Gallery Images *')</label>

                            <div class="w-100">
                                <label for="gallery_upload">
                                    <div class="template-btn black-btn" type="button">+ @lang('Set Gallery')</div>
                                </label>
                            </div>



                            <input type="file" class="d-none" name="gallery[]" multiple id="gallery_upload">


                            <div class="row" id="view_gallery">
                                @foreach ($data->galleries as $gallery)
                                    <div class="col-6  col-sm-3 col-lg-6 col col-xxl-4  mt-2">
                                        <div class="position-relative img-wh-80">
                                            <img class="img-wh-80 rounded-4  object-fit-cover"
                                                src="{{ asset('assets/images/galleries/' . $gallery->photo) }}"
                                                alt="">
                                            <button class="gallery-extra-remove-btn position-abs-center"><i
                                                    class="fa-solid fa-xmark"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        <!-- Product Current Price -->
                        <div class="input-label-wrapper">
                            <label>@lang('Product Current Price') ({{ $curr->name }})</label>
                            <input type="text" class="form-control" name="price"
                                placeholder="{{ round($data->price * $sign->value, 2) }}">
                        </div>
                        <!-- Product Discount Price -->
                        <div class="input-label-wrapper">
                            <label>@lang('Product Discount Price* (Optional)')</label>
                            <input type="text" class="form-control" name="previous_price"
                                placeholder="{{ round($data->previous_price * $sign->value, 2) }}">
                        </div>
                        <!-- YouTube Video URL-->
                        <div class="input-label-wrapper">
                            <label>@lang('YouTube Video URL* (Optional)')</label>
                            <input type="text" class="form-control" name="youtube" placeholder="@lang('Enter YouTube Video URL')"
                                value="{{ $data->youtube }}">
                        </div>
                        <!-- Feature Tags -->
                        <div class="input-label-wrapper">
                            <label>@lang('Feature Tags')</label>
                            <div id="feature-section">

                                @if ($data->features != '' && count($data->features) > 0)

                                    @foreach ($data->features as $key => $data1)
                                        <div class="row row-cols-1 row-cols-sm-2 gy-4 mb-3">
                                            <div class="col feature-tag-color-input-wrapper">
                                                <input type="text" class="form-control" name="features[]"
                                                    placeholder="@lang('Enter Your Keyword')"
                                                    value="{{ $data->features[$key] }}">
                                            </div>
                                            <div class="col feature-tag-keyword-input-wrapper">

                                                <div class="w-100  position-relative">
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ $data->colors[$key] }}">
                                                    <input class="h-100 position-absolute top-0 end-0 color-input"
                                                        type="color" id="favcolor_2" name="colors[]"
                                                        value="{{ $data->colors[$key] }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row row-cols-1 row-cols-sm-2 gy-4 mb-3">
                                        <div class="col feature-tag-color-input-wrapper">
                                            <input type="text" class="form-control" name="features[]"
                                                placeholder="@lang('Enter Your Keyword')">
                                        </div>
                                        <div class="col feature-tag-keyword-input-wrapper">
                                            <div class="w-100  position-relative">
                                                <input type="text" class="form-control" placeholder="#000000 ">
                                                <input class="h-100 position-absolute top-0 end-0 color-input"
                                                    type="color" id="favcolor_2" name="colors[]" value="#000000">
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                            <div class="col-12 col-sm-12 mt-4">
                                <div class="d-flex justify-content-end">
                                    <button class="template-btn black-btn px-20" id="feature-btn"
                                        type="button">+@lang('Add
                                                                                                                                                                                                        More Field')</button>
                                </div>
                            </div>
                        </div>


                        <!-- Tags -->
                        <div class="input-label-wrapper">
                            <label>@lang('Tags')</label>
                            <input type="text" class="form-control" id="tags" name="product-tags"
                                placeholder="@lang('Enter YouTube Video URL')"
                                value="{{ is_array($data->tags) && implode(',', $data->tags) }}">
                        </div>
                        <!-- Create Product Button  -->
                        <button class="template-btn w-100 px-20" type="submit">@lang('Update Product')</button>
                    </div>
                </div>
            </div>
            <!-- form sidebar end  -->
        </form>
        <!-- add product form end -->

    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/nicEdit.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.Jcrop.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.SimpleCropper.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select2.js') }}"></script>


    <script>
        (function($) {
            "use strict";


            document.addEventListener("DOMContentLoaded", function() {
                bkLib.onDomLoaded(function() {
                    // Initialize nicEditor for each class or ID as required
                    var editors = document.getElementsByClassName("nic-edit");
                    for (var i = 0; i < editors.length; i++) {
                        new nicEditor().panelInstance(editors[i]);
                    }
                });

            });




            $(document).ready(function() {

                let html =
                    `<img width="200" src="{{ empty($data->photo) ? asset('assets/images/noimage.png') : (filter_var($data->photo, FILTER_VALIDATE_URL) ? $data->photo : asset('assets/images/products/' . $data->photo)) }}" alt="">`;
                $(".span4.cropme").html(html);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            });




            $('.cropme').simpleCropper();


            $(document).on('click', "#color-btn", function() {
                $("#color-section").append(`<div class="col-12 mt-2 position-relative">
                    <input type="text" class="form-control" name="product-colors"
                        placeholder="#000000 ">
                    <input class="h-100 position-absolute top-0 end-0 color-input" type="color"
                        id="favcolor_1" name="favcolor" value="#000000">
                </div>`);
            });



            $(document).on('click', "#whole-btn", function() {
                $("#whole-section").append(
                    ` <div class="row row-cols-1 row-cols-md-3 gy-4 postion-relative">
                    <div class="col">
                        <input type="text" class="form-control" name="product-whole-sell-quantity"
                            placeholder="@lang('Enter Quantity') ">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="product-whole-sell-discount"
                            placeholder="@lang('Enter Discount Percentage') ">
                    </div>
                    <button type="button" class="delete-item-btn text-danger remove_whole_sell"><i class="fa-solid fa-trash-can"></i></button>
                </div>`
                );
            });


            $(document).on('click', ".remove_whole_sell", function() {
                if ($('.remove_whole_sell').length > 1) {
                    $(this).parent().parent().remove();
                }
            });


            $(document).on('click', "#size-btn", function() {

                $("#size-section").append(
                    `   <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 align-items-end gx-3 gy-4">
                                <!-- Size Name -->
                                <div class="col">
                                    <div class="lebel-box">
                                        <label class="main-label">Size Name :</label>
                                        <label class="sub-label">(eg. S,M,L,XL,3XL,4XL)</label>
                                    </div>
                                    <input type="text" class="form-control" name="size[]" placeholder="">
                                </div>
                                <div class="col">
                                    <div class="lebel-box">
                                        <label class="main-label">Size Qty :</label>
                                        <label class="sub-label">(Quantity of this size)</label>
                                    </div>
                                    <input type="text" class="form-control" name="size_qty[]" placeholder="">
                                </div>
                                <div class="col">
                                    <div class="lebel-box">
                                        <label class="main-label">Size Price :</label>
                                        <label class="sub-label">(Added with base price)</label>
                                    </div>
                                    <input type="text" class="form-control" name="size_price[]" placeholder="">
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-danger remove_stock">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>`
                );
            });

            $(document).on('click', ".remove_stock", function() {
                if ($('.remove_stock').length > 1) {
                    $(this).parent().parent().remove();
                }
            });



            $(document).on("change", "#gallery_upload", function() {

                var file = $(this)[0].files;
                var file_length = file.length;
                for (let i = 0; i < file_length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#view_gallery').append(`<div class="col-3 position-relative mt-2">
                    <img class="img-wh-80 rounded-4  object-fit-cover"  src="${e.target.result}" alt="">
                    <button class="gallery-extra-remove-btn position-abs-center remove_gallery"><i class="fa-solid fa-xmark"></i></button>
                </div>`);
                    }
                    reader.readAsDataURL(this.files[i]);
                }

            });
            $(document).on('click', '.remove_gallery', function() {
                $(this).parent().parent().remove();
            });


            $(document).on("change", "#gallery_upload", function() {

                var file = $(this)[0].files;
                var file_length = file.length;
                for (let i = 0; i < file_length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#view_gallery').append(`<div class="col-3 position-relative mt-2">
                                    <img class="img-wh-80 rounded-4  object-fit-cover"  src="${e.target.result}" alt="">
                                    <button class="gallery-extra-remove-btn position-abs-center remove_gallery"><i class="fa-solid fa-xmark"></i></button>
                                </div>`);
                    }
                    reader.readAsDataURL(this.files[i]);
                }

            });
            $(document).on('click', '.remove_gallery', function() {
                $(this).parent().parent().remove();
            });



            $(document).on('click', "#feature-btn", function() {

                $("#feature-section").append(
                    ` <div class="row row-cols-1 row-cols-sm-2 gy-4 mb-3">
                        <div class="col feature-tag-color-input-wrapper">
                            <input type="text" class="form-control" name="features[]"
                                placeholder="@lang('Enter Your Keyword')">
                        </div>
                        <div class="col feature-tag-keyword-input-wrapper">
                            <div class="w-100  position-relative">

                                <input class="h-100 position-absolute top-0 end-0 color-input" type="color"
                                    id="favcolor_2" name="colors[]" value="#000000">
                            </div>
                        </div>
                    </div>`
                );
            });






            $('#myForm').on('submit', function(e) {
                // Prevent form from submitting immediately
                e.preventDefault();

                var editors = document.getElementsByClassName('nic-edit');
                for (var i = 0; i < editors.length; i++) {
                    console.log(editors[i]);
                    var editorInstance = nicEditors.findEditor(editors[i].id); // Find the nicEditor instance
                    if (editorInstance) {
                        editors[i].value = editorInstance
                            .getContent(); // Update the textarea value with the nicEditor content
                    }
                }

                // Clear previous hidden inputs
                $('.dynamic-input').remove();

                // Iterate through checkboxes
                $('.attr-checkbox').each(function() {
                    var checkbox = $(this);
                    var priceInputId = "#" + checkbox.attr('id') + "_price";
                    var priceInput = $(priceInputId);

                    if (checkbox.prop('checked')) {
                        var priceValue = priceInput.val().length > 0 ? priceInput.val() : "0.00";
                        var inputName = priceInput.data('name');

                        // Create hidden input and append to form
                        $('<input>').attr({
                            type: 'hidden',
                            name: inputName,
                            value: priceValue,
                            class: 'dynamic-input'
                        }).appendTo('#myForm');
                    }
                });

                // Submit the form
                this.submit();
            });





        })(jQuery);
    </script>
@endsection