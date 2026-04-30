@extends('layouts.admin')


@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Conditional Offer') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Home Page Settings') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-conditional-offer-index') }}">{{ __('Conditional Offer') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct" style="padding: 17px;">

                        @include('alerts.admin.form-success')

                        <div class="table-responsive">
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    <h3 class="table-title">{{ __('Conditional Offers') }}</h3>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><a href="{{ route('admin-conditional-offer-create') }}"
                                        class="add-btn"><i class="fas fa-plus"></i>{{ __('Add New Offer') }}</a>
                                </div>
                            </div>
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Offer Name</th>
                                        <th>Min. Purchase</th>
                                        <th>Offer Product</th>
                                        <th>Offer Price</th>
                                        <th>Excluded SKUs</th>
                                        <th>Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offers as $offer)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ $offer->name }}</div>
                                                @if ($offer->description)
                                                    <small
                                                        class="text-muted">{{ Str::limit($offer->description, 60) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary fw-semibold fs-6">
                                                    ৳{{ number_format($offer->min_purchase_amount, 0) }}
                                                </span>
                                            </td>
                                            <td>

                                                @foreach ($offer->offer_products ? json_decode($offer->offer_products) : [] as $item)
                                                    <div class="bg-primary mb-1 rounded text-white p-1">
                                                        <small class="">Amount {{ $item->amount ?? '—' }}</small>
                                                        <small class="">Sku {{ $item->sku ?? '' }}</small>
                                                    </div>
                                                @endforeach

                                            </td>
                                            <td>
                                                <span
                                                    class="text-danger fw-bold">৳{{ number_format($offer->offer_price, 0) }}</span>
                                                <small class="text-muted">× {{ $offer->offer_quantity }}</small>
                                            </td>
                                            <td>
                                                @forelse($offer->excluded_sku ? json_decode($offer->excluded_sku) : [] as $ex)
                                                    <span class="badge badge-success me-1">{{ $ex }}</span>
                                                @empty
                                                    <span class="text-muted small">কোনোটি নেই</span>
                                                @endforelse
                                            </td>
                                            <td class="small">
                                                @if ($offer->starts_at || $offer->ends_at)
                                                    {{ $offer->starts_at ? \Carbon\Carbon::parse($offer->starts_at)->format('d M Y') : '—' }}
                                                    –
                                                    {{ $offer->ends_at ? \Carbon\Carbon::parse($offer->ends_at)->format('d M Y') : '—' }}
                                                @else
                                                    <span class="text-muted">সীমা নেই</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $class = $offer->is_active ? 'drop-success' : 'drop-danger';
                                                @endphp
                                                <div class="action-list">
                                                    <select class="process select droplinks {{ $class ?? '' }}">

                                                        <option data-val="1"
                                                            value="{{ route('admin-conditional-offer-status', [$offer->id, 1]) }}"
                                                            {{ $offer->is_active ? 'selected' : '' }}>
                                                            {{ __('Activated') }}
                                                        </option>

                                                        <option data-val="0"
                                                            value="{{ route('admin-conditional-offer-status', [$offer->id, 0]) }}"
                                                            {{ !$offer->is_active ? 'selected' : '' }}>
                                                            {{ __('Deactivated') }}
                                                        </option>

                                                    </select>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin-conditional-offer-edit', $offer->id) }}"
                                                    class="btn btn-sm btn-secondary "><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('admin-conditional-offer-delete', $offer->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
