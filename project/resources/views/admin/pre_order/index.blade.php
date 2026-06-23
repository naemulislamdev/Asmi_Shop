@extends('layouts.admin')

@section('styles')
    <style type="text/css">
        .input-field {
            padding: 15px 20px;
        }

        .note-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all .25s ease;
            z-index: 9999;
        }

        .note-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .note-modal-box {
            background: #ffffff;
            width: 450px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
            transform: scale(.85) translateY(10px);
            transition: all .25s ease;
            overflow: hidden;
        }

        .note-modal-overlay.active .note-modal-box {
            transform: scale(1) translateY(0);
        }

        .note-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            background: #f7f9fc;
            border-bottom: 1px solid #e5e7eb;
        }

        .note-modal-title {
            font-size: 15px;
            font-weight: 600;
            color: #333;
        }

        .note-modal-close {
            font-size: 22px;
            cursor: pointer;
            color: #666;
            transition: color .2s;
        }

        .note-modal-close:hover {
            color: #000;
        }

        .note-modal-body {
            padding: 18px;
            font-size: 14px;
            color: #444;
            line-height: 1.6;
            max-height: 260px;
            overflow-y: auto;
        }

        .note-modal-footer {
            padding: 12px 18px;
            text-align: right;
            border-top: 1px solid #e5e7eb;
            background: #fafafa;
        }

        .note-ok-btn {
            background: #0d6efd;
            color: #fff;
            border: none;
            padding: 6px 18px;
            font-size: 13px;
            border-radius: 4px;
            cursor: pointer;
            transition: background .2s;
        }

        .note-ok-btn:hover {
            background: #0b5ed7;
        }

        .note-modal-close {
            color: #dc3545;
            transition: all 0.3s ease-in-out
        }

        .note-modal-close:hover {
            background: #dc3545;
            color: #fff;
        }

        table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
            top: 77% !important;
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
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="from_date">From Date</label>
                                    <input type="date" id="from_date" class="form-control" placeholder="From Date">
                                </div>
                                <div class="col-md-3">
                                    <label for="to_date">To Date</label>
                                    <input type="date" id="to_date" class="form-control" placeholder="To Date">
                                </div>
                                <div class="col-md-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="orderStatus" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="pending">
                                            {{ __('Pending') }}</option>
                                        <option value="confirmed">
                                            {{ __('Confirmed') }}</option>
                                        <option value="cancelled">
                                            {{ __('Cancel') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="filter_btn" class="btn btn-primary mt-3">Filter</button>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="reset_btn" class="btn btn-secondary mt-3">Reset</button>
                                </div>

                            </div>
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('SL') }}</th>
                                        <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Customer Phone') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- DATA TABLE --}}

    <script type="text/javascript">
        var currentStatus = 'all';
        (function($) {
            "use strict";


            var table = $('#geniustable').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,


                ajax: {
                    url: '{{ route('admin.pre_order.datatables', 'all') }}',
                    data: function(d) {
                        d.date_from = $('#from_date').val();
                        d.date_to = $('#to_date').val();
                        d.status = $('#orderStatus').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'customer_phone',
                        name: 'customer_phone'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    processing: '<img src="{{ asset('assets/images/' . $gs->admin_loader) }}">'
                },
                drawCallback: function(settings) {
                    $('.select').niceSelect();
                }
            });

            // Filter button click
            $('#filter_btn').on('click', function() {
                table.ajax.reload();
            });

            // Reset button click
            $('#reset_btn').on('click', function() {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#orderStatus').val('');
                table.ajax.reload();
            });

        })(jQuery);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('click', '.delete-order', function() {

            let url = $(this).data('href');

            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('This order will be permanently deleted') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: "{{ __('Yes, delete it!') }}",
                cancelButtonText: "{{ __('Cancel') }}"
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire(
                                "{{ __('Deleted!') }}",
                                res.message,
                                'success'
                            );

                            $('#geniustable').DataTable().ajax.reload(null, false);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        const updateStatusUrlBase = "{{ route('admin.pre_order.update_status', ['id' => ':id']) }}";
    </script>
    <script>
        $(document).on('change', '.status-select', function() {
            let id = $(this).data('id');
            let status = $(this).val();
            let url = updateStatusUrlBase.replace(':id', id);

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: status
                },
                success: function(res) {
                    toastr.success(res.message);
                    $('#geniustable').DataTable().ajax.reload(null, false); // false = keep current page
                },
                error: function() {
                    toastr.error('Status update failed!');
                }
            });
        });
    </script>
@endsection
