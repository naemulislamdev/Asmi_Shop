@extends('layouts.admin')

@section('styles')
    <style type="text/css">
        .input-field {
            padding: 15px 20px;
        }
    </style>
@endsection

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('ORDER') }}">

    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="heading">{{ __('All Orders') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Orders') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('admin-orders-all') }}">{{ __('All Orders') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <!-----Export button dropdown----->
                    <div class="btn-group float-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">
                            {{ __('Export') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">
                        @include('alerts.admin.form-success')
                        @include('alerts.form-success')
                        <div class="table-responsive">
                            <div class="gocover"
                                style="background: url({{ asset('assets/images/' . $gs->admin_loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Address') }}</th>
                                        <th>{{ __('Branch') }}</th>
                                        <th>{{ __('Order Number') }}</th>
                                        <th>{{ __('Total Qty') }}</th>
                                        <th>{{ __('Total Cost') }}</th>
                                        <th>{{ __('Options') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ORDER MODAL --}}

    <div class="modal fade" id="confirm-delete1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="submit-loader">
                    <img src="{{ asset('assets/images/' . $gs->admin_loader) }}" alt="">
                </div>
                <div class="modal-header d-block text-center">
                    <h4 class="modal-title d-inline-block">{{ __('Update Status') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">{{ __("You are about to update the order's Status.") }}</p>
                    <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                    <input type="hidden" id="t-add" value="{{ route('admin-order-track-add') }}">
                    <input type="hidden" id="t-id" value="">
                    <input type="hidden" id="t-title" value="">
                    <textarea class="input-field" placeholder="{{ __('Enter Your Tracking Note (Optional)') }}" id="t-txt"></textarea>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-success btn-ok order-btn">{{ __('Proceed') }}</a>
                </div>

            </div>
        </div>
    </div>

    {{-- ORDER MODAL ENDS --}}



    {{-- MESSAGE MODAL --}}
    <div class="sub-categori">
        <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vendorformLabel">{{ __('Send Email') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="contact-form">
                                        <form id="emailreply">
                                            {{ csrf_field() }}
                                            <ul>
                                                <li>
                                                    <input type="email" class="input-field eml-val" id="eml"
                                                        name="to" placeholder="{{ __('Email') }} *" value=""
                                                        required="">
                                                </li>
                                                <li>
                                                    <input type="text" class="input-field" id="subj"
                                                        name="subject" placeholder="{{ __('Subject') }} *"
                                                        required="">
                                                </li>
                                                <li>
                                                    <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }} *"
                                                        required=""></textarea>
                                                </li>
                                            </ul>
                                            <button class="submit-btn" id="emlsub"
                                                type="submit">{{ __('Send Email') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MESSAGE MODAL ENDS --}}

    {{-- ADD / EDIT MODAL --}}

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="submit-loader">
                    <img src="{{ asset('assets/images/' . $gs->admin_loader) }}" alt="">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>

    </div>

    {{-- ADD / EDIT MODAL ENDS --}}
    <!-- Button trigger modal -->
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Orders</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="GET" action="{{ route('orders.export') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exportFormat">Select Export Format:</label>
                            <select class="form-control" id="exportFormat" name="format">
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exportCategory">Order Status</label>
                            <select class="form-control" name="status">
                                <option value="all">All</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="from_date">From Date</label>
                            <input type="date" class="form-control" name="from_date" required>
                        </div>

                        <div class="form-group">
                            <label for="to_date">To Date</label>
                            <input type="date" class="form-control" name="to_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- DATA TABLE --}}

    <script type="text/javascript">
        (function($) {
            "use strict";

            var table = $('#geniustable').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin-order-datatables', 'none') }}',
                columns: [{
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'customer_address',
                        name: 'customer_address'
                    },
                    {
                        data: 'branch',
                        name: 'branch'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'totalQty',
                        name: 'totalQty'
                    },
                    {
                        data: 'pay_amount',
                        name: 'pay_amount'
                    },
                    {
                        data: 'action',
                        searchable: false,
                        orderable: false
                    }
                ],
                language: {
                    processing: '<img src="{{ asset('assets/images/' . $gs->admin_loader) }}">'
                },
                drawCallback: function(settings) {
                    $('.select').niceSelect();
                }
            });

            $(function() {
                $(".btn-area").append('<div class="col-sm-4 table-contents">' +
                    '<a class="add-btn" href="{{ route('admin-order-create') }}">' +
                    '<i class="fas fa-plus"></i> <span class="remove-mobile">{{ __('Add an Order') }}<span>' +
                    '</a>' +
                    '</div>');
            });

        })(jQuery);
    </script>

    {{-- DATA TABLE --}}
@endsection
