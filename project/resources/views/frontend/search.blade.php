@extends('layouts.front')

@section('content')
<div class="container py-4">
    <h4>Search results for: "{{ $keyword }}"</h4>
    <div class="row mt-3">
        @forelse ($products as $product)
            @include('includes.frontend.home_product')
        @empty
            <div class="col-12"><p>No products found.</p></div>
        @endforelse
    </div>

    {{ $products->links() }}
</div>
@endsection
