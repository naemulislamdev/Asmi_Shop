@extends('layouts.admin')

@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Create Combo Offer') }} <a class="add-btn"
                            href="{{ route('admin.combo-offer.index') }}"><i class="fas fa-arrow-left"></i>
                            {{ __('Back') }}</a></h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.combo-offer.index') }}">{{ __('Combo Offers') }}</a>
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
                            <form action="{{ route('admin.combo-offer.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @include('alerts.admin.form-both')
                                {{-- Sub Title Section --}}

                                <div class="row">
                                    <div class="col-12">
                                        <div>
                                            <label class="control-label" for="title_text">{{ __('Offer Title') }}*</label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Add title here">
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="image">Banner Image (optional)</label>
                                            <input type="file" id="customImageUpload" class="form-control-file"
                                                name="image">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div style="max-height: 200px; width: 200px;" class="rounded">
                                            <img id="viewer" src="" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label"
                                                for="deal_details">{{ __('Add Products') }}*</label>
                                            <select id="productSelect" class="form-control select2" name="product_ids[]"
                                                multiple="multiple">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-name="{{ $product->name }}"
                                                        data-sku="{{ $product->sku }}" data-price="{{ $product->price }}">
                                                        {{ $product->name }} || {{ $product->sku }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('product_ids')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Table -->
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table align-middle"
                                                style="border-collapse: separate; border-spacing: 0;">
                                                <thead>
                                                    <tr style="background:#f8f9fa;">
                                                        <th style="width:60px; border-bottom: 2px solid #dee2e6;">SL</th>
                                                        <th style="border-bottom: 2px solid #dee2e6;">Product Name</th>
                                                        <th style="border-bottom: 2px solid #dee2e6;">Product SKU</th>
                                                        <th style="border-bottom: 2px solid #dee2e6;">Product Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="product-table-body"></tbody>
                                            </table>
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
        const row = `
    <tr data-id="${id}" style="border-bottom: 1px dashed #dee2e6;">
        <td>${index + 1}</td>
        <td><a href="#" style="color:#4a90d9; text-decoration:none;">${name}</a></td>
        <td style="color:#4a90d9;">${sku}</td>
        <td>${parseFloat(price).toFixed(2)}</td>
    </tr>
`;
    </script>

    <script>
        $(document).ready(function() {
            const $select = $("#productSelect");
            const $tableBody = $("#product-table-body");

            // Initialize Select2
            $select.select2({
                width: "resolve",
                placeholder: "Select products",
            });

            // When selection changes
            $select.on("change", function() {
                const selectedOptions = $(this).find("option:selected");
                const selectedIds = selectedOptions.map((_, opt) => $(opt).val()).get();

                // Clear current table rows
                $tableBody.empty();

                // Add rows for selected products
                selectedOptions.each(function(index) {
                    const id = $(this).val();
                    const name = $(this).data("name");
                    const sku = $(this).data("sku");
                    const price = $(this).data("price");

                    const row = `
                <tr data-id="${id}">
                    <td>${index + 1}</td>
                    <td>${name}</td>
                    <td>${sku}</td>
                    <td>${price}</td>

                </tr>
            `;
                    $tableBody.append(row);
                });
            });
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customImageUpload").change(function() {
            readURL(this);
        });
    </script>
@endsection
