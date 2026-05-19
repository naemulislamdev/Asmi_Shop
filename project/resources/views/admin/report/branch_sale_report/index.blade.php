@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="content-area p-2">

            {{-- Breadcrumb --}}
            <div class="mr-breadcrumb">
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="heading">{{ __('Branch Sales Report') }}</h4>
                        <ul class="links">
                            <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li><a href="javascript:;">{{ __('Reports') }}</a></li>
                            <li><a href="#">{{ __('Branch Sales Report') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Filter Card --}}
            <div class="card mb-0 rounded-bottom-0" style="box-shadow: 3px 0 6px rgba(0,0,0,0.08)!important;">
                <div class="card-body pt-3">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label>Branch</label>
                            <select id="branch_id" class="form-control">
                                <option value="all">All Branches</option>
                                <option value="notAssignedBranch">Not assigned Branches</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Status</label>
                            <select id="statusFilter" class="form-control">
                                <option value="all">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="hold">Hold</option>
                                <option value="processing">Processing</option>
                                <option value="on delivery">On Delivery</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>From Date</label>
                            <input type="date" id="from_date" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label>To Date</label>
                            <input type="date" id="to_date" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <button id="filter_btn" class="btn btn-primary mt-1">Filter</button>
                        </div>
                        <div class="col-md-1">
                            <button id="reset_btn" class="btn btn-secondary mt-1">Reset</button>
                        </div>
                    </div>

                    {{-- Summary Cards --}}
                    <div class="row mt-4" id="summaryCards">
                        @php
                            $cards = [
                                [
                                    'id' => 'all',
                                    'label' => 'All Orders',
                                    'color' => 'linear-gradient(135deg,#1e3a5f,#2d6a9f)',
                                    'qty' => 's_total_orders',
                                    'amt' => 's_total_amount',
                                ],
                                [
                                    'id' => 'pending',
                                    'label' => 'Pending',
                                    'color' => 'linear-gradient(135deg,#f4a200,#f7c948)',
                                    'qty' => 's_pending_qty',
                                    'amt' => 's_pending_amount',
                                ],
                                [
                                    'id' => 'hold',
                                    'label' => 'Hold',
                                    'color' => 'linear-gradient(135deg,#555,#888)',
                                    'qty' => 's_hold_qty',
                                    'amt' => 's_hold_amount',
                                ],
                                [
                                    'id' => 'processing',
                                    'label' => 'Processing',
                                    'color' => 'linear-gradient(135deg,#0077b6,#00b4d8)',
                                    'qty' => 's_processing_qty',
                                    'amt' => 's_processing_amount',
                                ],
                                [
                                    'id' => 'on_delivery',
                                    'label' => 'On Delivery',
                                    'color' => 'linear-gradient(135deg,#5a189a,#9d4edd)',
                                    'qty' => 's_on_delivery_qty',
                                    'amt' => 's_on_delivery_amount',
                                ],
                                [
                                    'id' => 'completed',
                                    'label' => 'Completed',
                                    'color' => 'linear-gradient(135deg,#1a5c45,#2d8c6a)',
                                    'qty' => 's_completed_qty',
                                    'amt' => 's_completed_amount',
                                ],
                                [
                                    'id' => 'cancelled',
                                    'label' => 'Cancelled',
                                    'color' => 'linear-gradient(135deg,#7b1a2a,#c0392b)',
                                    'qty' => 's_cancelled_qty',
                                    'amt' => 's_cancelled_amount',
                                ],
                            ];
                        @endphp
                        @foreach ($cards as $card)
                            <div class="col-md-3 mb-3">
                                <div style="background:{{ $card['color'] }}; border-radius:14px; padding:16px; color:#fff;">
                                    <div style="font-weight:700; font-size:14px;">{{ $card['label'] }}</div>
                                    <div style="margin-top:6px; font-size:13px;">
                                        {{ $loop->first ? 'Total' : '' }} Qty: <span id="{{ $card['qty'] }}">0</span><br>
                                        {{ $loop->first ? 'Total' : '' }} Amount: <span id="{{ $card['amt'] }}">0</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- Branch Breakdown Table --}}
            <div class="card mt-0 rounded-top-0 mt-3 p-2">
                <h3>Sales Products Table</h3>
                <div class="card-body p-0" style="position:relative;">
                    <div id="loader" class="gocover"
                        style="background: url({{ asset('assets/images/' . $gs->admin_loader) }}) no-repeat scroll center center rgba(45,45,45,0.5); display:none;">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0" id="branchTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Attributes</th>
                                    <th>SKU</th>
                                    <th>Qty</th>
                                    <th>Total Selling Amount</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var summaryUrl = '{{ route('admin.branch.sales.summary') }}';
        var datatableUrl = '{{ route('admin.branch.sales.datatable') }}';

        function getFilters() {
            return {
                branch_id: $('#branch_id').val(),
                status: $('#statusFilter').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
            };
        }

        // Summary load
        function loadSummary() {
            $.ajax({
                url: summaryUrl,
                data: getFilters(),
                success: function(s) {
                    $('#s_total_orders').text(s.total_orders);
                    $('#s_total_amount').text(s.total_amount);
                    $('#s_pending_qty').text(s.pending_qty);
                    $('#s_pending_amount').text(s.pending_amount);
                    $('#s_hold_qty').text(s.hold_qty);
                    $('#s_hold_amount').text(s.hold_amount);
                    $('#s_processing_qty').text(s.processing_qty);
                    $('#s_processing_amount').text(s.processing_amount);
                    $('#s_on_delivery_qty').text(s.on_delivery_qty);
                    $('#s_on_delivery_amount').text(s.on_delivery_amount);
                    $('#s_completed_qty').text(s.completed_qty);
                    $('#s_completed_amount').text(s.completed_amount);
                    $('#s_cancelled_qty').text(s.cancelled_qty);
                    $('#s_cancelled_amount').text(s.cancelled_amount);
                }
            });
        }

        // DataTable init
        var table = $('#branchTable').DataTable({
            processing: true,
            serverSide: false, // collection based, serverSide off
            ajax: {
                url: datatableUrl,
                data: function(d) {
                    var f = getFilters();
                    d.branch_id = f.branch_id;
                    d.status = f.status;
                    d.from_date = f.from_date;
                    d.to_date = f.to_date;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'image',
                    name: 'image',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'attribute',
                    name: 'attribute',
                    searchable: false
                },
                {
                    data: 'sku',
                    name: 'sku'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'total_amount',
                    name: 'total_amount'
                },
            ],
            language: {
                processing: '<img src="{{ asset('assets/images/' . $gs->admin_loader) }}">'
            }
        });

        // Page load
        loadSummary();

        // Filter
        $('#filter_btn').on('click', function() {
            loadSummary();
            table.ajax.reload();
        });

        // Reset
        $('#reset_btn').on('click', function() {
            $('#branch_id').val('all');
            $('#statusFilter').val('all');
            $('#from_date').val('');
            $('#to_date').val('');
            loadSummary();
            table.ajax.reload();
        });
    </script>
@endsection
