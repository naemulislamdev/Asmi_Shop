@extends('layouts.front')
@section('content')
    <section class="gs-cart-section load_cart">
        @include('frontend.ajax.cart-page')
    </section>
@endsection

