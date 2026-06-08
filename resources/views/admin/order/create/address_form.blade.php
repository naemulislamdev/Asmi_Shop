@if (Session::has('order_address'))
@php
    $user = Session::get('order_address');
@endphp
<div class="row mt-2">
  <div class="col col-md-4 col-sm-6">
    <label for="name">Name *</label>
    <input type="text" class="form-control" required name="customer_name" id="name" value="{{$user['customer_name']}}" placeholder="Name">
  </div>

  <div class="col col-md-4 col-sm-6">
    <label for="phone">Phone *</label>
    <input type="text" class="form-control" required name="customer_phone" id="phone" placeholder="Phone" value="{{$user['customer_phone']}}">
  </div>
  <div class="col col-md-12 col-sm-12">
    <label for="customer_address">Address *</label>
    <input type="text" class="form-control" required name="customer_address" id="customer_address" placeholder="Address" value="{{$user['customer_address']}}">
  </div>
</div>

@else

@php
    $isUser = isset($isUser) ? $isUser : false;
@endphp
@if ($isUser == 1)
  <div class="row mt-2">
    <div class="col col-md-4 col-sm-6">
      <label for="name">Name *</label>
      <input type="text" class="form-control" required name="customer_name" id="name" value="{{$user['name']}}" placeholder="Name">
    </div>

    <div class="col col-md-4 col-sm-6">
      <label for="phone">Phone *</label>
      <input type="text" class="form-control" required name="customer_phone" id="phone" placeholder="Phone" value="{{$user['phone']}}">
    </div>
    <div class="col col-md-12 col-sm-12">
      <label for="customer_address">Address *</label>
      <input type="text" class="form-control" required name="customer_address" id="customer_address" placeholder="Address" value="{{$user['address']}}">
    </div>
  </div>

@else

  <div class="row mt-2">
    <div class="col col-md-4 col-sm-6">
      <label for="name">Name *</label>
      <input type="text" class="form-control" required name="customer_name" id="name" placeholder="Name">
    </div>
    <div class="col col-md-4 col-sm-6">
      <label for="phone">Phone *</label>
      <input type="text" class="form-control" required name="customer_phone" id="phone" placeholder="Email">
    </div>
    <div class="col col-md-12 col-sm-12">
      <label for="customer_address">Address *</label>
      <input type="text" class="form-control" required name="customer_address" id="customer_address" placeholder="Address">
    </div>
  </div>
@endif

@endif
