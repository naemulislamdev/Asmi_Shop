@extends('layouts.front')
@section('content')
    <section class="gs-cart-section load_cart my-0 py-3">
        @include('frontend.ajax.cart-page')
    </section>
@endsection
