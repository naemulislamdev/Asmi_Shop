@extends('layouts.admin')
@section('styles')
    <link href="{{ asset('assets/admin/css/product.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/jquery.Jcrop.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/Jcrop-style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/select2.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading"> {{ __('Edit Product') }}<a class="add-btn" href="{{ url()->previous() }}"><i
                                class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-prod-index') }}">{{ __('Products') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Physical Product') }}</a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Edit') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <form id="geniusform" action="{{ route('admin-prod-update', $data->id) }}" method="POST"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            @include('alerts.admin.form-both')
            <div class="row">
                <div class="col-lg-8">
                    <div class="add-product-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-description">
                                    <div class="body-area">
                                        <div class="gocover"
                                            style="background: url({{ asset('assets/images/' . $gs->admin_loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Name') }}* </h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="text" class="input-field"
                                                    placeholder="{{ __(" Enter Product
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        												Name") }}"
                                                    name="name" required="" value="{{ $data->name }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Sku') }}* </h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="text" class="input-field"
                                                    placeholder="{{ __('Enter Product Sku') }}" name="sku"
                                                    required="" value="{{ $data->sku }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <select id="cat" name="category_id" required="">
                                                    <option>{{ __('Select Category') }}</option>
                                                    @foreach ($cats as $cat)
                                                        <option data-href="{{ route('admin-subcat-load', $cat->id) }}"
                                                            value="{{ $cat->id }}"
                                                            {{ $cat->id == $data->category_id ? 'selected' : '' }}>
                                                            {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Sub Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <select id="subcat" name="subcategory_id">
                                                    <option value="">{{ __('Select Sub Category') }}</option>
                                                    @if ($data->subcategory_id == null)
                                                        @foreach ($data->category->subs as $sub)
                                                            <option
                                                                data-href="{{ route('admin-childcat-load', $sub->id) }}"
                                                                value="{{ $sub->id }}">{{ $sub->name }}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($data->category->subs as $sub)
                                                            <option
                                                                data-href="{{ route('admin-childcat-load', $sub->id) }}"
                                                                value="{{ $sub->id }}"
                                                                {{ $sub->id == $data->subcategory_id ? 'selected' : '' }}>
                                                                {{ $sub->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Child Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <select id="childcat" name="childcategory_id"
                                                    {{ $data->subcategory_id == null ? 'disabled' : '' }}>
                                                    <option value="">{{ __('Select Child Category') }}</option>
                                                    @if ($data->subcategory_id != null)
                                                        @if ($data->childcategory_id == null)
                                                            @foreach ($data->subcategory->childs as $child)
                                                                <option value="{{ $child->id }}">{{ $child->name }}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            @foreach ($data->subcategory->childs as $child)
                                                                <option value="{{ $child->id }} "
                                                                    {{ $child->id == $data->childcategory_id ? 'selected' : '' }}>
                                                                    {{ $child->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        @php
                                            $selectedAttrs = json_decode($data->attributes, true);

                                        @endphp

                                        {{-- Attributes of category starts --}}
                                        <div id="catAttributes">
                                            @php
                                                $catAttributes = !empty($data->category->attributes)
                                                    ? $data->category->attributes
                                                    : '';
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
                                                                                    <span
                                                                                        class="price-curr">{{ $sign->sign }}</span>
                                                                                    <input type="text"
                                                                                        class="input-field price-input"
                                                                                        id="{{ $catAttribute->input_name }}{{ $option->id }}_price"
                                                                                        data-name="{{ $catAttribute->input_name }}_price[]"
                                                                                        placeholder="0.00 (Additional Price)"
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
                                                                                    <span
                                                                                        class="price-curr">{{ $sign->sign }}</span>
                                                                                    <input type="text"
                                                                                        class="input-field price-input"
                                                                                        id="{{ $subAttribute->input_name }}{{ $option->id }}_price"
                                                                                        data-name="{{ $subAttribute->input_name }}_price[]"
                                                                                        placeholder="0.00 (Additional Price)"
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
                                                                                    <span
                                                                                        class="price-curr">{{ $sign->sign }}</span>
                                                                                    <input type="text"
                                                                                        class="input-field price-input"
                                                                                        id="{{ $childAttribute->input_name }}{{ $option->id }}_price"
                                                                                        data-name="{{ $childAttribute->input_name }}_price[]"
                                                                                        placeholder="0.00 (Additional Price)"
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
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input class="checkclick1" name="measure_check" type="checkbox"
                                                            id="measure_check" value="1"
                                                            {{ $data->measure == 1 ? 'checked' : '' }}>
                                                        <label
                                                            for="measure_check">{{ __('Allow Product Measurement') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class=" {{ $data->measure == 1 ? '' : 'showbox' }}">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Product Measurement') }}*</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <table class="table" id="measureTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Value</th>
                                                                <th>Label</th>
                                                                <th>Price (optional)</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data->measures as $index => $measure)
                                                                <tr>
                                                                    <td>
                                                                        <input type="number"
                                                                            name="measures[{{ $index }}][value]"
                                                                            class="input-field measure-value"
                                                                            step="0.01" value="{{ $measure->value }}">
                                                                    </td>

                                                                    <td>
                                                                        <input type="text"
                                                                            name="measures[{{ $index }}][label]"
                                                                            class="input-field measure-label"
                                                                            value="{{ $measure->label }}">
                                                                    </td>

                                                                    <td>
                                                                        <input type="number"
                                                                            name="measures[{{ $index }}][price]"
                                                                            class="input-field measure-price"
                                                                            step="0.01" value="{{ $measure->price }}">
                                                                    </td>

                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm remove"><i
                                                                                class="fas fa-trash-alt"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        id="addMeasure">
                                                        + Add Measure
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input class="checkclick1" name="product_condition_check"
                                                            type="checkbox" id="conditionCheck" value="1"
                                                            {{ $data->product_condition != 0 ? 'checked' : '' }}>
                                                        <label
                                                            for="conditionCheck">{{ __('Allow Product Condition') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="{{ $data->product_condition == 0 ? ' showbox' : '' }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Product Condition') }}*</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <select name="product_condition">
                                                        <option value="2"
                                                            {{ $data->product_condition == 2 ? 'selected' : '' }}>
                                                            {{ __('New') }}</option>
                                                        <option value="1"
                                                            {{ $data->product_condition == 1 ? 'selected' : '' }}>
                                                            {{ __('Used') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input class="checkclick1" name="preordered_check"
                                                            type="checkbox" id="preorderedCheck" value="1"
                                                            {{ $data->preordered != 0 ? 'checked' : '' }}>
                                                        <label
                                                            for="preorderedCheck">{{ __('Allow Product Preorder') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="{{ $data->preordered == 0 ? ' showbox' : '' }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Product Preorder') }}*</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <select name="preordered">
                                                        <option value="1"
                                                            {{ $data->preordered == 1 ? 'selected' : '' }}>
                                                            {{ __('Sale') }}</option>
                                                        <option value="2"
                                                            {{ $data->preordered == 2 ? 'selected' : '' }}>
                                                            {{ __('Preordered') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input class="checkclick1" name="minimum_qty_check"
                                                            type="checkbox" id="check111" value="1"
                                                            {{ $data->minimum_qty != null ? 'checked' : '' }}>
                                                        <label for="check111">{{ __('Allow Minimum Order Qty') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="{{ $data->minimum_qty != null ? '' : ' showbox' }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Product Minimum Order Qty') }}* </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <input type="number" class="input-field" min="1"
                                                        placeholder="{{ __('Minimum Order Qty') }}" name="minimum_qty"
                                                        value="{{ $data->minimum_qty == null ? '' : $data->minimum_qty }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input class="checkclick1" name="shipping_time_check"
                                                            type="checkbox" id="check1" value="1"
                                                            {{ $data->ship != null ? 'checked' : '' }}>
                                                        <label
                                                            for="check1">{{ __('Allow Estimated Shipping Time') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>


                                        <div class="{{ $data->ship != null ? '' : ' showbox' }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Product Estimated Shipping Time') }}*
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <input type="text" class="input-field"
                                                        placeholder="{{ __('Estimated Shipping Time') }}" name="ship"
                                                        value="{{ $data->ship == null ? '' : $data->ship }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input class="checkclick1" name="is_flash_deal" type="checkbox"
                                                            id="flash" value="1"
                                                            {{ $data->is_flash_deal != 0 ? 'checked' : '' }}>
                                                        <label for="flash">{{ __('Allow Flash Deal') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>


                                        <div class="{{ $data->is_flash_deal != 0 ? '' : 'showbox' }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Product Flash Deal') }}*
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Start Date</label>
                                                    <input type="date" class="input-field"
                                                        placeholder="{{ __('Start Date') }}" name="start_date"
                                                        value="{{ $data->start_date == null ? '' : $data->start_date }}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>End Date</label>
                                                    <input type="date" class="input-field"
                                                        placeholder="{{ __('End Date') }}" name="end_date"
                                                        value="{{ $data->end_date == null ? '' : $data->end_date }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input class="checkclickc" name="color_check" type="checkbox"
                                                            id="check3" value="1"
                                                            {{ is_array($data->color_all) ? 'checked' : '' }}>
                                                        <label for="check3">{{ __('Allow Product Colors') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        @php

                                        @endphp
                                        <div class="{{ is_array($data->color_all) ? '' : ' showbox' }}">
                                            <div class="row">

                                                <div class="col-lg-12">
                                                    <div class="select-input-color" id="color-section">
                                                        @if (is_array($data->color_all))

                                                            @foreach ($data->color_all as $key => $color)
                                                                <div class="size-area">
                                                                    <span class="remove size-remove"><i
                                                                            class="fas fa-times"></i></span>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12">
                                                                            <label>
                                                                                {{ __('Color') }} :
                                                                            </label>
                                                                            <div class="color-area">
                                                                                <div
                                                                                    class="input-group colorpicker-component cp">
                                                                                    <input type="text"
                                                                                        name="color_all[]"
                                                                                        value="{{ $color }}"
                                                                                        class="input-field cp tcolor" />
                                                                                    <span
                                                                                        class="input-group-addon"><i></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                        @endif

                                                    </div>
                                                    <a href="javascript:;" id="color-btn" class="add-more mt-4 mb-3"><i
                                                            class="fas fa-plus"></i>{{ __('Add More Color') }} </a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input name="pre_order" class="stock-check" type="checkbox"
                                                            id="pre-order" value="1"
                                                            {{ $data->pre_order == 1 ? 'checked' : '' }}>
                                                        <label for="pre-order"
                                                            class="stock-text">{{ __('Make This Product on Pre Order') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input name="stock_check" class="stock-check" type="checkbox"
                                                            id="size-check" value="200"
                                                            {{ !empty($data->size) ? 'checked' : '' }}>
                                                        <label for="size-check"
                                                            class="stock-text">{{ __('Manage Stock') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>


                                        <div class="row {{ !empty($data->size) ? ' d-none' : '' }}" id="default_stock">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Stock') }}*</h4>
                                                    <p class="sub-heading">
                                                        {{ __('(Leave Empty will Show Always Available)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="stock" type="number" class="input-field"
                                                    placeholder="e.g 20" value="{{ $data->stock }}" min="0">
                                            </div>
                                        </div>


                                        @php
                                            if (is_array($data->size)) {
                                                $sizes = $data->size;
                                            } else {
                                                $sizes = array_filter(explode(',', $data->size));
                                            }
                                        @endphp

                                        <div class="{{ !empty($sizes) ? '' : ' showbox' }}" id="size-display">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="product-size-details" id="size-section">


                                                        @foreach ($sizes as $key => $size)
                                                            <div class="size-area">
                                                                <span class="remove size-remove"><i
                                                                        class="fas fa-times"></i></span>
                                                                <div class="row">
                                                                    <div class="col-md-4 col-sm-4">
                                                                        <label>
                                                                            {{ __('Size Name') }} :
                                                                            <span>
                                                                                {{ __('(eg. S,M,L,XL,3XL,4XL)') }}
                                                                            </span>
                                                                        </label>
                                                                        <input type="text" name="size[]"
                                                                            class="input-field tsize"
                                                                            placeholder="{{ __('Enter Product Size') }}"
                                                                            value="{{ $size }}" required="">
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-4">
                                                                        <label>
                                                                            {{ __('Size Qty') }} :
                                                                            <span>
                                                                                {{ __('(Quantity of this size)') }}
                                                                            </span>
                                                                        </label>
                                                                        <input type="number" name="size_qty[]" required
                                                                            class="input-field"
                                                                            placeholder="{{ __('Size Qty') }}"
                                                                            value="{{ $data->size_qty[$key] }}"
                                                                            min="1">
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-4">
                                                                        <label>
                                                                            {{ __('Size Price') }} :
                                                                            <span>
                                                                                {{ __('(Added with base price)') }}
                                                                            </span>
                                                                        </label>
                                                                        <input type="number" name="size_price[]" required
                                                                            class="input-field"
                                                                            placeholder="{{ __('Size Price') }}"
                                                                            value="{{ round($data->size_price[$key] * $curr->value, 2) }}"
                                                                            min="0">
                                                                    </div>


                                                                </div>
                                                            </div>
                                                        @endforeach


                                                    </div>

                                                    <a href="javascript:;" id="size-btn" class="add-more"><i
                                                            class="fas fa-plus"></i>{{ __('Add More') }} </a>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input class="checkclick1" name="whole_check" type="checkbox"
                                                            id="whole_check" value="1"
                                                            {{ !empty($data->whole_sell_qty) ? 'checked' : '' }}>
                                                        <label
                                                            for="whole_check">{{ __('Allow Product Whole Sell') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="{{ !empty($data->whole_sell_qty) ? '' : ' showbox' }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">

                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="featured-keyword-area">
                                                        <div class="feature-tag-top-filds" id="whole-section">
                                                            @if (!empty($data->whole_sell_qty))

                                                                @foreach ($data->whole_sell_qty as $key => $data1)
                                                                    <div class="feature-area">
                                                                        <span class="remove whole-remove"><i
                                                                                class="fas fa-times"></i></span>
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <input type="number"
                                                                                    name="whole_sell_qty[]"
                                                                                    class="input-field"
                                                                                    placeholder="{{ __('Enter Quantity') }}"
                                                                                    min="0"
                                                                                    value="{{ $data->whole_sell_qty[$key] }}"
                                                                                    required="">
                                                                            </div>

                                                                            <div class="col-lg-6">
                                                                                <input type="number"
                                                                                    name="whole_sell_discount[]"
                                                                                    class="input-field"
                                                                                    placeholder="{{ __('Enter Discount Percentage') }}"
                                                                                    min="0"
                                                                                    value="{{ $data->whole_sell_discount[$key] }}"
                                                                                    required="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="feature-area">
                                                                    <span class="remove whole-remove"><i
                                                                            class="fas fa-times"></i></span>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="number" name="whole_sell_qty[]"
                                                                                class="input-field"
                                                                                placeholder="{{ __('Enter Quantity') }}"
                                                                                min="0">
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <input type="number"
                                                                                name="whole_sell_discount[]"
                                                                                class="input-field"
                                                                                placeholder="{{ __('Enter Discount Percentage') }}"
                                                                                min="0" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            @endif
                                                        </div>

                                                        <a href="javascript:;" id="whole-btn" class="add-fild-btn"><i
                                                                class="icofont-plus"></i> {{ __('Add More Field') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">
                                                        {{ __('Product Description') }}*
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-editor">
                                                    <textarea name="details" class="nic-edit">{{ $data->details }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">
                                                        {{ __('Product Buy/Return Policy') }}*
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-editor">
                                                    <textarea name="policy" class="nic-edit">{{ $data->policy }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="checkbox-wrapper">
                                                    <input type="checkbox" name="seo_check" value="1"
                                                        class="checkclick" id="allowProductSEO"
                                                        {{ $data->meta_tag != null || strip_tags($data->meta_description) != null ? 'checked' : '' }}>
                                                    <label for="allowProductSEO">{{ __('Allow Product SEO') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="{{ $data->meta_tag == null && strip_tags($data->meta_description) == null ? 'showbox' : '' }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Meta Tags') }} *</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <ul id="metatags" class="myTags">
                                                        @if (!empty($data->meta_tag))
                                                            @foreach ($data->meta_tag as $element)
                                                                <li>{{ $element }}</li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">
                                                            {{ __('Meta Description') }} *
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="text-editor">
                                                        <textarea name="meta_description" class="input-field" placeholder="{{ __('Details') }}">{{ $data->meta_description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="add-product-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-description">
                                    <div class="body-area">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Feature Image') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="panel panel-body">
                                                    <div class="span4 cropme text-center" id="landscape"
                                                        style="width: 100%; height: 285px; border: 1px dashed #ddd; background: #f1f1f1;">
                                                        <a href="javascript:;" id="crop-image"
                                                            class="d-inline-block mybtn1">
                                                            <i class="icofont-upload-alt"></i>
                                                            {{ __('Upload Image Here') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="feature_photo" name="photo"
                                            value="{{ $data->photo }}" accept="image/*">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">
                                                        {{ __('Product Gallery Images') }} *
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <a href="javascript" class="set-gallery" data-toggle="modal"
                                                    data-target="#setgallery">
                                                    <input type="hidden" value="{{ $data->id }}">
                                                    <i class="icofont-plus"></i> {{ __('Set Gallery') }}
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">
                                                        {{ __('Product Current Price') }}*
                                                    </h4>
                                                    <p class="sub-heading">
                                                        ({{ __('In') }} {{ $sign->name }})
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="price" type="number" class="input-field"
                                                    placeholder="e.g 20" step="any" value="{{ $data->price }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Discount Price') }}*</h4>
                                                    <p class="sub-heading">{{ __('(Optional)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="discount" type="number"
                                                    value="{{ round($data->discount * $sign->value, 2) }}"
                                                    class="input-field" placeholder="{{ __('e.g 20') }}"
                                                    min="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Discount type') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <select class="form-control" name="discount_type">
                                                    <option selected disabled>{{ __('Select Type') }}</option>
                                                    <option {{ $data->discount_type == 'flat' ? 'selected' : '' }}
                                                        value="flat">{{ __('Flat') }}</option>
                                                    <option {{ $data->discount_type == 'percent' ? 'selected' : '' }}
                                                        value="percent">{{ __('Percentage') }}</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Youtube Video URL') }}*</h4>
                                                    <p class="sub-heading">{{ __('(Optional)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="youtube" type="text" class="input-field"
                                                    placeholder="Enter Youtube Video URL" value="{{ $data->youtube }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="featured-keyword-area">
                                                    <div class="left-area">
                                                        <h4 class="title">{{ __('Feature Tags') }}</h4>
                                                    </div>

                                                    <div class="feature-tag-top-filds" id="feature-section">
                                                        @if (!empty($data->features))

                                                            @foreach ($data->features as $key => $data1)
                                                                <div class="feature-area">
                                                                    <span class="remove feature-remove"><i
                                                                            class="fas fa-times"></i></span>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <input type="text" name="features[]"
                                                                                class="input-field"
                                                                                placeholder="{{ __('Enter Your Keyword') }}"
                                                                                value="{{ $data->features[$key] }}">
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <div
                                                                                class="input-group colorpicker-component cp">
                                                                                <input type="text" name="colors[]"
                                                                                    value="{{ $data->colors[$key] }}"
                                                                                    class="input-field cp" />
                                                                                <span
                                                                                    class="input-group-addon"><i></i></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="feature-area">
                                                                <span class="remove feature-remove"><i
                                                                        class="fas fa-times"></i></span>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <input type="text" name="features[]"
                                                                            class="input-field"
                                                                            placeholder="{{ __('Enter Your Keyword') }}">
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="input-group colorpicker-component cp">
                                                                            <input type="text" name="colors[]"
                                                                                value="#000000" class="input-field cp" />
                                                                            <span class="input-group-addon"><i></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        @endif
                                                    </div>

                                                    <a href="javascript:;" id="feature-btn" class="add-fild-btn"><i
                                                            class="icofont-plus"></i> {{ __('Add More Field') }}</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Tags') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul id="tags" class="myTags">
                                                    @if (!empty($data->tags))
                                                        @foreach ($data->tags as $element)
                                                            <li>{{ $element }}</li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row text-center">
                                            <div class="col-6 offset-3">
                                                <button class="addProductSubmit-btn"
                                                    type="submit">{{ __('Save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Image Gallery') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="top-area">
                        <div class="row">
                            <div class="col-sm-6 text-right">
                                <div class="upload-img-btn">
                                    <form method="POST" enctype="multipart/form-data" id="form-gallery">
                                        @csrf
                                        <input type="hidden" id="pid" name="product_id" value="">
                                        <input type="file" name="gallery[]" class="hidden" id="uploadgallery"
                                            accept="image/*" multiple>
                                        <label for="image-upload" id="prod_gallery"><i
                                                class="icofont-upload-alt"></i>{{ __('Upload File') }}</label>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <a href="javascript:;" class="upload-done" data-dismiss="modal"> <i
                                        class="fas fa-check"></i> {{ __('Done') }}</a>
                            </div>
                            <div class="col-sm-12 text-center">(
                                <small>{{ __('You can upload multiple Images.') }}</small>
                                )
                            </div>
                        </div>
                    </div>
                    <div class="gallery-images">
                        <div class="selected-image">
                            <div class="row">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let index = {{ $data->measures->count() }};

        document.getElementById('addMeasure').addEventListener('click', function() {
            let row = `
        <tr>
            <td>
                <input type="number" step="0.001" name="measures[${index}][value]"
                    class="input-field measure-value" readonly>
            </td>
            <td>
                <input type="text" name="measures[${index}][label]"
                    class="input-field measure-label"
                    placeholder="eg. 250g, 1kg, 500ml, 1L, 2pcs">
            </td>
            <td>
                <input type="number" step="0.01" name="measures[${index}][price]"
                    class="input-field measure-price">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        `;
            document.querySelector('#measureTable tbody').insertAdjacentHTML('beforeend', row);
            index++;
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove')) {
                e.target.closest('tr').remove();
            }
        });

        // Auto calculate value & price
        document.addEventListener('input', function(e) {

            if (!e.target.classList.contains('measure-label')) return;

            let label = e.target.value.toLowerCase(); // keep spaces
            let row = e.target.closest('tr');

            let valueInput = row.querySelector('.measure-value');
            let priceInput = row.querySelector('.measure-price');

            let basePrice = parseFloat(document.querySelector('input[name="price"]').value || 0);
            let value = 0;

            // ===== WEIGHT =====
            let kgMatch = label.match(/([\d.]+)\s*kg/);
            let gMatch = label.match(/([\d.]+)\s*(g|gm)/);
            let lbMatch = label.match(/([\d.]+)\s*(lb|pound)/);

            if (kgMatch) value += parseFloat(kgMatch[1]);
            if (gMatch) value += parseFloat(gMatch[1]) / 1000;
            if (lbMatch) value += parseFloat(lbMatch[1]) * 0.453592;

            // ===== LIQUID =====
            let lMatch = label.match(/([\d.]+)\s*(l|ltr)/);
            let mlMatch = label.match(/([\d.]+)\s*ml/);

            if (lMatch) value += parseFloat(lMatch[1]);
            if (mlMatch) value += parseFloat(mlMatch[1]) / 1000;

            // ===== PIECES =====
            let pcsMatch = label.match(/([\d.]+)\s*(pcs|pc|piece)/);
            if (pcsMatch) value += parseFloat(pcsMatch[1]);

            if (value > 0) {
                valueInput.value = value.toFixed(3);

                // Auto price calculation
                if (basePrice > 0) {
                    priceInput.value = (basePrice * value).toFixed(2);
                }
            } else {
                valueInput.value = '';
                priceInput.value = '';
            }
        });
    </script>

    <script type="text/javascript">
        // Gallery Section Update



        $(document).on("click", ".set-gallery", function() {
            var pid = $(this).find('input[type=hidden]').val();
            $('#pid').val(pid);
            $('.selected-image .row').html('');
            $.ajax({
                type: "GET",
                url: "{{ route('admin-gallery-show') }}",
                data: {
                    id: pid
                },
                success: function(data) {
                    if (data[0] == 0) {
                        $('.selected-image .row').addClass('justify-content-center');
                        $('.selected-image .row').html('<h3>{{ __('No Images Found.') }}</h3>');
                    } else {
                        $('.selected-image .row').removeClass('justify-content-center');
                        $('.selected-image .row h3').remove();
                        var arr = $.map(data[1], function(el) {
                            return el
                        });

                        for (var k in arr) {
                            $('.selected-image .row').append('<div class="col-sm-6">' +
                                '<div class="img gallery-img">' +
                                '<span class="remove-img"><i class="fas fa-times"></i>' +
                                '<input type="hidden" value="' + arr[k]['id'] + '">' +
                                '</span>' +
                                '<a href="' + '{{ asset('assets/images/galleries') . '/' }}' +
                                arr[
                                    k]['photo'] + '" target="_blank">' +
                                '<img src="' + '{{ asset('assets/images/galleries') . '/' }}' +
                                arr[
                                    k]['photo'] + '" alt="gallery image">' +
                                '</a>' +
                                '</div>' +
                                '</div>');
                        }
                    }

                }
            });
        });


        $(document).on('click', '.remove-img', function() {
            var id = $(this).find('input[type=hidden]').val();
            $(this).parent().parent().remove();
            $.ajax({
                type: "GET",
                url: "{{ route('admin-gallery-delete') }}",
                data: {
                    id: id
                }
            });
        });

        $(document).on('click', '#prod_gallery', function() {
            $('#uploadgallery').click();
        });


        $("#uploadgallery").change(function() {
            $("#form-gallery").submit();
        });

        $('#form-gallery').on('submit', function() {
            $.ajax({
                url: "{{ route('admin-gallery-store') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data != 0) {
                        $('.selected-image .row').removeClass('justify-content-center');
                        $('.selected-image .row h3').remove();
                        var arr = $.map(data, function(el) {
                            return el
                        });
                        for (var k in arr) {
                            $('.selected-image .row').append('<div class="col-sm-6">' +
                                '<div class="img gallery-img">' +
                                '<span class="remove-img"><i class="fas fa-times"></i>' +
                                '<input type="hidden" value="' + arr[k]['id'] + '">' +
                                '</span>' +
                                '<a href="' + '{{ asset('assets/images/galleries') . '/' }}' +
                                arr[
                                    k]['photo'] + '" target="_blank">' +
                                '<img src="' + '{{ asset('assets/images/galleries') . '/' }}' +
                                arr[
                                    k]['photo'] + '" alt="gallery image">' +
                                '</a>' +
                                '</div>' +
                                '</div>');
                        }
                    }

                }

            });
            return false;
        });


        $('.cp').colorpicker();

        // Gallery Section Update Ends
    </script>

    <script src="{{ asset('assets/admin/js/jquery.Jcrop.js') }}"></script>

    <script src="{{ asset('assets/admin/js/jquery.SimpleCropper.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select2.js') }}"></script>

    <script type="text/javascript">
        (function($) {
            "use strict";

            $('.cropme').simpleCropper();

            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Select Products",
                    maximumSelectionLength: 4,
                });
            });

        })(jQuery);
    </script>


    <script type="text/javascript">
        (function($) {
            "use strict";

            $(document).ready(function() {

                let html =
                    `<img src="{{ empty($data->photo) ? asset('assets/images/noimage.png') : (filter_var($data->photo, FILTER_VALIDATE_URL) ? $data->photo : asset('assets/images/products/' . $data->photo)) }}" alt="">`;
                $(".span4.cropme").html(html);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            });


            $('.ok').on('click', function() {

                setTimeout(
                    function() {


                        var img = $('#feature_photo').val();

                        $.ajax({
                            url: "{{ route('admin-prod-upload-update', $data->id) }}",
                            type: "POST",
                            data: {
                                "image": img
                            },
                            success: function(data) {
                                if (data.status) {
                                    $('#feature_photo').val(data.file_name);
                                }
                                if ((data.errors)) {
                                    for (var error in data.errors) {
                                        $.notify(data.errors[error], "danger");
                                    }
                                }
                            }
                        });

                    }, 1000);



            });

        })(jQuery);
    </script>

    <script type="text/javascript">
        (function($) {
            "use strict";

            $('#imageSource').on('change', function() {
                var file = this.value;
                if (file == "file") {
                    $('#f-file').show();
                    $('#f-link').hide();
                }
                if (file == "link") {
                    $('#f-file').hide();
                    $('#f-link').show();
                }
            });



            $(document).on('click', '#size-check', function() {
                if ($(this).is(':checked')) {
                    $('#default_stock').addClass('d-none')
                } else {
                    $('#default_stock').removeClass('d-none');
                }
            })



        })(jQuery);
    </script>


    @include('partials.admin.product.product-scripts')
@endsection
