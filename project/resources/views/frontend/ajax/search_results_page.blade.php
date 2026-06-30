@forelse ($products as $product)
    @include('includes.frontend.home_product')
@empty
    <div class="col-12">
        <p>No products found.</p>
    </div>
@endforelse

<div class="col-12">
    {{ $products->links('includes.frontend.pagination') }}
</div>
