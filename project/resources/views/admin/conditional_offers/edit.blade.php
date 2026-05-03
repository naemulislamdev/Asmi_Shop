@extends('layouts.admin')

@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">
                        {{ __('Edit Conditional Offer') }}
                        <a class="add-btn" href="{{ route('admin-conditional-offer-index') }}">
                            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="add-product-content1 add-product-content2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area p-3">

                            <form action="{{ route('admin-conditional-offer-update', $offer->id) }}" method="POST">
                                @csrf

                                @include('alerts.admin.form-both')

                                {{-- BASIC INFO --}}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Offer Name </label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $offer->name) }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Min Purchase Amount </label>
                                        <input type="number" name="min_purchase_amount" class="form-control"
                                            value="{{ old('min_purchase_amount', round($offer->min_purchase_amount)) }}"
                                            required>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Max Uses Per Order</label>
                                        <input type="number" name="max_uses_per_order" class="form-control"
                                            value="{{ old('max_uses_per_order', $offer->max_uses_per_order) }}">
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Offer Quantity </label>
                                        <input type="number" name="offer_quantity" class="form-control"
                                            value="{{ old('offer_quantity', $offer->offer_quantity) }}" required>
                                    </div>
                                </div>

                                {{-- DYNAMIC TABLE --}}
                                @php
                                    $offerProducts = json_decode($offer->offer_products ?? '[]', true);
                                @endphp

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <table class="table table-bordered" id="myTable">
                                            <tr>
                                                <th>Offer Amount</th>
                                                <th>Offer Product SKU</th>
                                                <th>Action</th>
                                            </tr>

                                            @if (!empty($offerProducts))
                                                @foreach ($offerProducts as $i => $product)
                                                    <tr>
                                                        <td>
                                                            <input type="number" name="offer_amount[]"
                                                                class="form-control mb-0" value="{{ $product['amount'] }}">
                                                        </td>

                                                        <td>
                                                            <input type="text" name="offer_product_sku[]"
                                                                class="form-control mb-0"
                                                                value="{{ $product['sku'] ?? '' }}">
                                                        </td>

                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm ml-3"
                                                                onclick="this.closest('tr').remove()">
                                                                Delete
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>
                                                        <input type="number" name="offer_amount[]" class="form-control"
                                                            placeholder="Offer Amount">
                                                    </td>

                                                    <td>
                                                        <input type="text" name="offer_product_sku[]"
                                                            class="form-control" placeholder="Offer Product SKU">
                                                    </td>

                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="this.closest('tr').remove()">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>

                                        <button type="button" class="btn btn-info" onclick="add_fields()">
                                            Add More
                                        </button>
                                    </div>
                                </div>

                                {{-- DATE --}}
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label>Offer Start Date</label>
                                        <input type="date" name="starts_at" class="form-control"
                                            value="{{ old('starts_at', optional($offer->starts_at)->format('Y-m-d')) }}">
                                    </div>

                                    <div class="col-6">
                                        <label>Offer End Date</label>
                                        <input type="date" name="ends_at" class="form-control"
                                            value="{{ old('ends_at', optional($offer->ends_at)->format('Y-m-d')) }}">
                                    </div>
                                </div>

                                {{-- EXCLUDED SKU --}}
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <label>Excluded Product SKU</label>
                                        @php
                                            // ✅ Safe decode (always array)
                                            $excludedSkus = [];

                                            if (!empty($offer->excluded_sku)) {
                                                $decoded = json_decode($offer->excluded_sku, true);
                                                $excludedSkus = is_array($decoded) ? $decoded : [];
                                            }
                                        @endphp

                                        <select class="form-control select2" name="excluded_sku[]" multiple>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->sku }}"
                                                    {{ in_array($product->sku, old('excluded_sku', $excludedSkus)) ? 'selected' : '' }}>
                                                    {{ $product->name }} | {{ $product->sku }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- SUBMIT --}}
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button class="btn btn-success" type="submit">
                                            Update Offer
                                        </button>
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
