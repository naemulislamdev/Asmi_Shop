@extends('layouts.admin')


@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Combo Offer') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>

                        <li>
                            <a href="{{ route('admin-conditional-offer-index') }}">{{ __('combo Offer') }}</a>
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
                                    <h3 class="table-title">{{ __('Combo Offers') }}</h3>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 text-right float-right"><a
                                        href="{{ route('admin.combo-offer.create') }}" class="add-btn "><i
                                            class="fas fa-plus"></i>{{ __('Add New Offer') }}</a>
                                </div>
                            </div>

                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#Sl</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>URL</th>
                                        <th>Total Products</th>
                                        <th>status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($offers as $i => $offer)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>
                                                @if ($offer->image)
                                                    <img style=""
                                                        src="{{ asset('assets/images/combo-offers/' . $offer->image) }}"
                                                        alt="{{ $offer->title }}">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $offer->title }}</div>
                                                @if ($offer->description)
                                                    <small
                                                        class="text-muted">{{ Str::limit($offer->description, 60) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('front.combo-product', $offer->slug) }}"
                                                    target="_blank">{{ $offer->slug }}</a>
                                            </td>
                                            <td>

                                                <button class="badge border-0 badge-primary">Total Products:
                                                    {{ count(json_decode($offer->product_ids)) }}</button>
                                            </td>

                                            <td>
                                                @php
                                                    $class = $offer->status ? 'drop-success' : 'drop-danger';
                                                @endphp
                                                <div class="action-list">
                                                    <select class="process select droplinks {{ $class ?? '' }}">

                                                        <option data-val="1"
                                                            value="{{ route('admin.combo-offer.status', [$offer->id, 1]) }}"
                                                            {{ $offer->staus ? 'selected' : '' }}>
                                                            {{ __('Activated') }}
                                                        </option>

                                                        <option data-val="0"
                                                            value="{{ route('admin.combo-offer.status', [$offer->id, 0]) }}"
                                                            {{ !$offer->status ? 'selected' : '' }}>
                                                            {{ __('Deactivated') }}
                                                        </option>

                                                    </select>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.combo-offer.edit', $offer->id) }}"
                                                    class="btn btn-sm btn-secondary "><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('admin.combo-offer.delete', $offer->id) }}"
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

@endsection
