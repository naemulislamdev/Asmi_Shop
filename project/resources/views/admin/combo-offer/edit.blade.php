@extends('layouts.admin')

@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Edit Combo Offer') }} <a class="add-btn"
                            href="{{ route('admin.combo-offer.index') }}"><i class="fas fa-arrow-left"></i>
                            {{ __('Back') }}</a></h4>
                    <ul class="links">
                        <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.combo-offer.index') }}">{{ __('Combo Offers') }}</a></li>
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

                            <form action="{{ route('admin.combo-offer.update', $offer->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                @include('alerts.admin.form-both')

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">{{ __('Offer Title') }}*</label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="Add title here" value="{{ old('title', $offer->title) }}">
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="control-label">{{ __('Offer Slug') }}*</label>
                                            <input type="text" class="form-control" name="slug"
                                                placeholder="Add Slug here" value="{{ old('slug', $offer->slug) }}">
                                            @error('slug')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Banner Image (optional)</label>
                                            <input type="file" id="customImageUpload" class="form-control-file"
                                                name="image">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div style="max-height: 200px; width: 200px;" class="rounded d-flex ">
                                            {{-- existing image --}}
                                            <img id="viewer"
                                                src="{{ $offer->image ? asset('assets/images/combo-offers/' . $offer->image) : '' }}"
                                                alt="" style="{{ $offer->image ? '' : 'display:none;' }}">
                                            @if ($offer->image)
                                                <button type="button"
                                                    class="btn btn-danger btn-sm ms-2 ml-2 d-inline-block"
                                                    onclick="deleteImage({{ $offer->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">{{ __('Add Products') }}*</label>
                                            <select id="productSelect" class="form-control select2" name="product_ids[]"
                                                multiple="multiple">
                                                @php
                                                    $selectedIds = json_decode($offer->product_ids, true) ?? [];
                                                @endphp
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-name="{{ $product->name }}"
                                                        data-sku="{{ $product->sku }}" data-price="{{ $product->price }}"
                                                        {{ in_array($product->id, $selectedIds) ? 'selected' : '' }}>
                                                        {{ $product->name }} || {{ $product->sku }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('product_ids')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

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
                                    <div class="col-lg-7 offset-lg-4">
                                        <button class="addProductSubmit-btn" type="submit">{{ __('Update') }}</button>
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
        // Previously selected product IDs from DB
        const preSelectedIds = @json(json_decode($offer->product_ids, true) ?? []);

        $(document).ready(function() {
            const $select = $("#productSelect");
            const $tableBody = $("#product-table-body");

            $select.select2({
                width: "resolve",
                placeholder: "Select products",
            });

            // Load pre-selected products into table on page load
            function renderTable() {
                $tableBody.empty();
                const selectedOptions = $select.find("option:selected");
                selectedOptions.each(function(index) {
                    const id = $(this).val();
                    const name = $(this).data("name");
                    const sku = $(this).data("sku");
                    const price = parseFloat($(this).data("price")).toFixed(2);

                    const row = `
                        <tr data-id="${id}" style="border-bottom: 1px dashed #dee2e6;">
                            <td>${index + 1}</td>
                            <td><a href="#" style="color:#4a90d9; text-decoration:none;">${name}</a></td>
                            <td style="color:#4a90d9;">${sku}</td>
                            <td>${price}</td>
                        </tr>
                    `;
                    $tableBody.append(row);
                });
            }

            // Render on page load
            renderTable();

            // Re-render on change
            $select.on("change", function() {
                renderTable();
            });
        });

        // Image preview
        function readURL(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customImageUpload").change(function() {
            readURL(this);
        });
    </script>
    <script>
        function deleteImage(id) {
            if (confirm('Are you sure you want to delete Image?')) {

                let url = "{{ route('admin.combo-offer.remove-img', ':id') }}";
                url = url.replace(':id', id);

                let form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                let csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                document.body.appendChild(form);
                form.appendChild(csrf);
                form.submit();
            }
        }
    </script>
@endsection
