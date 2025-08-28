@extends('layouts.admin')

@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Create Flash Deal') }} <a class="add-btn" href="{{ route('admin-flash-deal-index') }}"><i
                                class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                    <ul class="links">

                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Home Page Settings') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('admin-ps-deal') }}">{{ __('Flash Deals') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="add-product-content1 add-product-content2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            <div class="gocover"
                                style="background: url({{ asset('assets/images/' . $gs->admin_loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>
                            <form id="" action="{{ route('admin-flash-deal-store') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('alerts.admin.form-both')
                                {{-- Sub Title Section --}}

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title_text">{{ __('Title') }}*</label>
                                            <input type="text" class="form-control" name="deal_title" value=""
                                                placeholder="Add title here">
                                                @error('deal_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="subtitle_text">{{ __('Sub Title') }}*</label>
                                            <input type="text" class="form-control" name="deal_subtitle" value=""
                                                placeholder="Add subtitle here">
                                                @error('deal_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label" for="start_date">{{ __('Start Date') }}*</label>
                                            <input type="date" class="form-control" name="start_date">
                                            @error('start_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label" for="end_date">{{ __('End Date') }}*</label>
                                            <input type="date" class="form-control" name="end_date">
                                            @error('end_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label" for="end_date">{{ __('Status') }}*</label>
                                            <select class="form-control" name="status">
                                                <option value="0">{{ __('Inactive') }}</option>
                                                <option value="1">{{ __('Active') }}</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label"
                                                for="deal_details">{{ __('Add Products') }}*</label>
                                            <select class="form-control select2" name="deal_products[]" multiple="multiple">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} || {{ $product->sku }}</option>
                                                @endforeach
                                            </select>
                                            @error('deal_products')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <button class="addProductSubmit-btn" type="submit">{{ __('Submit') }}</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select products",
                allowClear: true
            });
        });
    </script>
@endsection
