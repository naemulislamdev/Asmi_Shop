@extends('layouts.admin')

<style>
    .offer-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    .offer-table th {
        background: #f8f9fa;
        padding: 12px;
        font-weight: 600;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }

    .offer-table td {
        padding: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
    }

    .offer-table input,
    .offer-table select {
        border-radius: 6px;
        height: 38px;
    }

    .btn-add {
        margin-top: 10px;
    }

    .btn-danger {
        padding: 5px 10px;
        font-size: 13px;
        border-radius: 6px;
    }
</style>

@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Create Conditional Offer') }} <a class="add-btn"
                            href="{{ route('admin-conditional-offer-index') }}"><i class="fas fa-arrow-left"></i>
                            {{ __('Back') }}</a></h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Home Page Settings') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('admin-conditional-offer-index') }}">{{ __('Conditional Offers') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="add-product-content1 add-product-content2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area p-3">
                            <div class="gocover"
                                style="background: url({{ asset('assets/images/' . $gs->admin_loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>
                            <form id="" action="{{ route('admin-conditional-offer-store') }}" method="POST"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('alerts.admin.form-both')
                                {{-- Sub Title Section --}}

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="form-label">Offer Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $offer->name ?? '') }}"
                                            placeholder="যেমন: Egg Offer on ৳2000 Purchase" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Minimum Purchase Amount (৳) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="min_purchase_amount" class="form-control" step="0.01"
                                            min="1"
                                            value="{{ old('min_purchase_amount', $offer->min_purchase_amount ?? '') }}"
                                            required>

                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Maximum Uses Per Order</label>
                                        <input type="number" name="max_uses_per_order" class="form-control" min="1"
                                            value="{{ old('max_uses_per_order', $offer->max_uses_per_order ?? 1) }}">
                                    </div>

                                    <div class="col-sm-6">
                                        <label class="form-label">Offer Quantity <span class="text-danger">*</span></label>
                                        <input type="number" name="offer_quantity" class="form-control" min="1"
                                            value="{{ old('offer_quantity', $offer->offer_quantity ?? 1) }}" required>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="set-form">
                                            <table id="myTable" class="table table-bordered">
                                                <tr>
                                                    <th>Offer Amount</th>
                                                    <th>Offer Product</th>
                                                    <th>Action</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="number" placeholder="Offer Amount"
                                                            name="offer_amount[]" value="" class="form-control mb-0">
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Offer Product SKU"
                                                            name="offer_product_sku[]" value=""
                                                            class="form-control mb-0">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-danger ml-4 mt-0">Delete</button>
                                                    </td>

                                                </tr>

                                            </table>
                                            <div class="set-form">
                                                <input type="button" id="more_fields" onclick="add_fields();"
                                                    value="Add More" class="btn btn-info" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label small">Offer Start Date</label>
                                        <input type="date" name="starts_at" class="form-control form-control-sm"
                                            value="{{ old('starts_at') }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Offer End Date</label>
                                        <input type="date" name="ends_at" class="form-control form-control-sm"
                                            value="{{ old('ends_at') }}">
                                    </div>
                                    <div class="col-12">
                                        <p class="form-text col-12 mb-0">খালি রাখলে সীমাহীন মেয়াদ।</p>
                                    </div>
                                </div>


                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label"
                                                for="deal_details">{{ __('Excluded Product Name or SKU') }}*</label>
                                            <select class="form-control select2" name="excluded_sku[]" multiple="multiple">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->sku }}">{{ $product->name }} ||
                                                        {{ $product->sku }}</option>
                                                @endforeach
                                            </select>
                                            @error('excluded_sku')
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
        $(document).ready(function() {
            $('.select3').select2({
                placeholder: "Select products",
                allowClear: true
            });
        });
    </script>
    <script>
        function add_fields() {
            document.getElementById("myTable").insertRow(-1).innerHTML =
                `<tr>
            <td>
                <input type="number" placeholder="Offer Amount"
                    name="offer_amount[]" value="" class="form-control mb-0">
            </td>

            <td>
                <input type="text" placeholder="Offer Product SKU"
                    name="offer_product_sku[]" value="" class="form-control mb-0">
            </td>

            <td>
                <button type="button" class="btn btn-sm btn-danger ml-3 mt-0"
                    onclick="this.closest('tr').remove()">
                    Delete
                </button>
            </td>
        </tr>`;
        }
    </script>
@endsection
