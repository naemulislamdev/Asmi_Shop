@extends('layouts.admin')

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('SLIDER') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Offer') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Home Page Settings') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-sl-index') }}">{{ __('Offer') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">

                        @include('alerts.admin.form-success')

                        <div class="table-responsive">
                            <div class="row my-2">
                                <div class="col-sm-4">
                                    <h3 class="table-title">{{ __('Flash Deals') }}</h3>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"><a href="{{ route('admin-flash-deal-create') }}" class="add-btn"><i class="fas fa-plus"></i>{{ __('Add New Flash Deal') }}</a></div>
                            </div>
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th >{{ __('Start Date') }}</th>
                                        <th >{{ __('End Date') }}</th>
                                        <th >{{ __('Total Products') }}</th>
                                        <th >{{ __('Status') }}</th>
                                        <th>{{ __('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($flashDeals as $flashDeal)
                                    @php
                                        $products_count = json_decode($flashDeal->products);

                                    @endphp
                                        <tr>
                                            <td>{{ $flashDeal->title }}</td>
                                            <td>{{ $flashDeal->start_date }}</td>
                                            <td>{{ $flashDeal->end_date }}</td>
                                            <td>{{ count($products_count) }}</td>
                                            <td>
                                                @if($flashDeal->status == 1)
                                                <span class="badge badge-success">{{ __('Active') }}</span>
                                                @else
                                                <span class="badge badge-danger">{{ __('Inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin-flash-deal-edit', $flashDeal->id) }}" class="add-btn">{{ __('Edit') }}</a>
                                                <a class="btn btn-danger delete-btn" href="{{ route('admin-flash-deal-delete', $flashDeal->id) }}">{{ __('Delete') }}</a>
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


    {{-- DELETE MODAL --}}

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header d-block text-center">
                    <h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">{{ __('You are about to delete this Slider.') }}</p>
                    <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="" class="d-inline delete-form" method="POST">
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- DELETE MODAL ENDS --}}
@endsection



@section('scripts')
@endsection
