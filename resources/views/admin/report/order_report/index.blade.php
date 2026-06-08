@extends('layouts.admin')

@section('content')
<style>
    .row-cards-one .mycard .right .icon {
    font-size: 50px;
}
.row-cards-one .mycard .left .number {
    font-size: 25px;
    line-height: 36px;
    font-weight: 600;
    display: block;
    color: #fff;
    margin-bottom: 5px;
}
</style>
    <input type="hidden" id="headerdata" value="{{ __('REPORT') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Reports') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-order-report-index') }}">{{ __('Reports') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area p-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="heading-area">
                        <h4 class="title">
                            {{ __('Order Report') }} :
                        </h4>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Form Date</label>
                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="from_date"
                            name="from_date">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" value="{{ date('Y-m-d') }}" class="form-control" id="to_date"
                            name="to_date">
                    </div>
                </div>
                <div class="col-md-4" style="margin-top: 30px">
                    <button class="btn btn-primary" onclick="dashboard_order_report_filter()">
                        Filter
                    </button>
                </div>

            </div>
            <div class="row row-cards-one" id="order_report">
                @include('admin.report.order_report.order_report_data', ['results' => $results,])
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function dashboard_order_report_filter() {
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();

            $.ajax({
                url: "{{ route('admin-order-report-filter') }}",
                type: "GET",
                data: {
                    from_date: from_date,
                    to_date: to_date
                },
                beforeSend: function() {
                    $('#order_report').html('<h4>Loading...</h4>');
                },
                success: function(response) {
                    $('#order_report').html(response.view);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endsection
