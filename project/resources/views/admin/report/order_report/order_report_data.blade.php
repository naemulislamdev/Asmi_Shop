<div class="col-md-12 col-lg-6 col-xl-4">
    <div class="mycard bg4">
        <div class="left">
            <h5 class="title">{{ __('Total Orders:') }}</h5>
            <span class="number">{{ $results->total_orders ?? 0 }}</span>
            <h5 class="title">{{ __('Total Amount:') }}</h5>
            <span class="number">{{ $results->pay_amount ?? 0 }}</span>
            <a href="{{ route('admin-orders-all') }}" class="link">{{ __('View All') }}</a>
        </div>
        <div class="right d-flex align-self-center">
            <div class="icon">
                <i class="icofont-clock-time"></i>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-6 col-xl-4">
    <div class="mycard bg3">
        <div class="left">
            <h5 class="title">{{ __('Completed Orders:') }}</h5>
            <span class="number">{{ $results->completed_qty ?? 0 }}</span>
            <h5 class="title">{{ __('Completed Amount:') }}</h5>
            <span class="number">{{ $results->completed_amount ?? 0 }}</span>
            <a href="{{ route('admin-orders-all') }}?status=completed" class="link">{{ __('View All') }}</a>
        </div>
        <div class="right d-flex align-self-center">
            <div class="icon">
                <i class="icofont-check-circled"></i>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-6 col-xl-4">
    <div class="mycard bg1">
        <div class="left">
            <h5 class="title">{{ __('Pending Orders:') }} </h5>
            <span class="number">{{ $results->pending_qty ?? 0 }}</span>
            <h5 class="title">{{ __('Pending Amount:') }}</h5>
            <span class="number">{{ $results->pending_amount ?? 0 }}</span>
            <a href="{{ route('admin-orders-all') }}?status=pending" class="link">{{ __('View All') }}</a>
        </div>
        <div class="right d-flex align-self-center">
            <div class="icon">
                <i class="icofont-clock-time"></i>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-6 col-xl-4">
    <div class="mycard bg2">
        <div class="left">
            <h5 class="title">{{ __('Processing Orders:') }}</h5>
            <span class="number">{{ $results->processing_qty ?? 0 }}</span>
            <h5 class="title">{{ __('Processing Amount:') }}</h5>
            <span class="number">{{ $results->processing_amount ?? 0 }}</span>

            <a href="{{ route('admin-orders-all') }}?status=processing" class="link">{{ __('View All') }}</a>
        </div>
        <div class="right d-flex align-self-center">
            <div class="icon">
                <i class="icofont-truck-alt"></i>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-6 col-xl-4">
    <div class="mycard bg2">
        <div class="left">
            <h5 class="title">{{ __('On Delivery Orders:') }}</h5>
            <span class="number">{{ $results->on_delivery_qty ?? 0 }}</span>
            <h5 class="title">{{ __('On Delivery Amount:') }}</h5>
            <span class="number">{{ $results->on_delivery_amount ?? 0 }}</span>
            <a href="{{ route('admin-orders-all') }}?status=on delivery" class="link">{{ __('View All') }}</a>
        </div>
        <div class="right d-flex align-self-center">
            <div class="icon">
                <i class="icofont-truck-alt"></i>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-lg-6 col-xl-4">
    <div class="mycard bg2">
        <div class="left">
            <h5 class="title">{{ __('Website Orders:') }}</h5>
            <span class="number">{{ $results->website_orders ?? 0 }}</span>
            <h5 class="title">{{ __('Mobile Apps Order:') }}</h5>
            <span class="number">{{ $results->mobile_app_orders ?? 0 }}</span>
            <a href="{{ route('admin-orders-all') }}" class="link">{{ __('View All') }}</a>
        </div>
        <div class="right d-flex align-self-center">
            <div class="icon">
               <i class="icofont-clock-time"></i>
            </div>
        </div>
    </div>
</div>
