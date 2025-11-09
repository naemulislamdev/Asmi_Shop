@extends('layouts.front')

@section('content')
<div class="container py-4">
    <h4>Search results for: "{{ $keyword }}"</h4>
    <div class="row mt-3">
        @forelse ($products as $product)
            <div class="col-md-3 col-6 mb-4">
                <a href="{{ route('front.product', $product->slug) }}" class="text-dark text-decoration-none">
                    <div class="card">
                        <img src="{{ $product['thumbnail'] ? asset('assets/images/thumbnails/' . $product['thumbnail']) : asset('assets/images/noimage.png') }}" class="card-img-top">
                        <div class="card-body text-center">
                            <h6 class="mb-1">{{ $product->name }}</h6>
                            <p class="text-primary mb-0">৳ {{ PriceHelper::showPrice($product['price']) }}</p>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12"><p>No products found.</p></div>
        @endforelse
    </div>

    {{ $products->links() }}
</div>
@endsection
