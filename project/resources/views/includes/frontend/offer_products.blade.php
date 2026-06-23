<div
    class="{{ isset($class) ? $class : 'col-6 col-sm-6 col-md-3 col-lg-2 col-xl-2 mb-3' }} {{ request()->is('search') ? 'mb-3' : '' }} ">
    {{-- 1taka dojon egg offer condition start --}}
    @php
        $cart = session('cart');

        $isOfferItem = false;

        if ($cart && $cart->items) {
            foreach ($cart->items as $cItem) {
                if ($cItem['item']->id == $product->id) {
                    $isOfferItem = $cItem['is_offer'] ?? false;
                }
            }
        }
    @endphp

    @php
        $offerMeta = session('offer_meta') ?? [
            'all_offer_skus' => [],
            'eligible_offer_skus' => [],
        ];

        $hasOfferInCart = session('has_offer_in_cart', false);

        $isOfferProduct = in_array($product->sku, $offerMeta['all_offer_skus']);
        $isEligible = in_array($product->sku, $offerMeta['eligible_offer_skus']);
    @endphp
    {{-- 1taka dojon egg offer condition end --}}
    <div class="single-product" data-sku="{{ $product->sku }}">
        <div class="img-wrapper">
            <div class="discount-box">
                @if ($product->discount > 0)
                    @if ($product->discount_type == 'percent')
                        <span>
                            {{ $product->discount }}% <small>OFF</small>
                        </span>
                    @elseif($product->discount_type == 'flat')
                        <span>
                            {{ $product->discount }}৳ <small>OFF</small>
                        </span>
                    @endif
                @endif
            </div>

            @if (Auth::check())
                @if (isset($wishlist))
                    <a href="javascript:;" class="removewishlist"
                        data-href="{{ route('user-wishlist-remove', App\Models\Wishlist::where('user_id', '=', $user->id)->where('product_id', '=', $product->id)->first()->id) }}">
                        <div class="add-to-wishlist-btn bg-danger">
                            <i class="fas fa-trash  text-white"></i>
                        </div>
                    </a>
                @else
                    <a href="javascript:;" class="wishlist" data-href="{{ route('user-wishlist-add', $product->id) }}">
                        <div class="add-to-wishlist-btn {{ wishlistCheck($product->id) ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z"
                                    stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                @endif
            @endif

            @php
                $cart = Session::has('cart') ? Session::get('cart') : null;
                $existingQty = 0;
                $uniqueKey = null;

                if ($cart && $cart->items) {
                    foreach ($cart->items as $key => $cItem) {
                        if ($cItem['item']->id == $product->id) {
                            $existingQty = $cItem['qty'];
                            $uniqueKey = $cItem['unique_key'];
                            break;
                        }
                    }
                }
            @endphp

             @php
    $basePath = '/home/asmishop/htdocs/asmishop.com/public';

    $imgSrc = asset('assets/images/noimage.png');

    if (
        $product->thumbnail &&
        file_exists($basePath . '/assets/images/thumbnails/' . $product->thumbnail)
    ) {
        $imgSrc = asset('assets/images/thumbnails/' . $product->thumbnail);
    } elseif (
        $product->photo &&
        file_exists($basePath . '/assets/images/products/' . $product->photo)
    ) {
        $imgSrc = asset('assets/images/products/' . $product->photo);
    }
@endphp


            <a href="{{ route('front.product', $product->slug) }}">
               <img class="product-img" src=" {{ $imgSrc }}" alt="product img">
            </a>
            @if ($product->stock <= 0)
                <div class="outofstock-box flex-column align-content-center justify-content-center">
                    @if ($product->preordered == 2)
                        <h5>{{ __('Make a Pre Order !') }}</h5>
                    @else
                        <h5>{{ __('Out of Stock !') }}</h5>
                    @endif
                </div>
            @endif
        </div>
        <div class="content-wrapper">
            <a href="{{ route('front.product', $product->slug) }}">
                <h6 class="product-title">{{ $product->showName() }}</h6>
            </a>
            <a href="{{ route('front.index') }}" class="btn btn-primary text-white">Go to Shopping</a>
            @if ($product->stock > 0 || $product->preordered == 2)
                <div class="price-wrapper">
                    @php
                        $basePrice =
                            $product->discount > 0
                                ? \App\Helpers\PriceHelper::discountPrice(
                                    $product->price,
                                    $product->discount,
                                    $product->discount_type,
                                )
                                : $product->price;
                    @endphp

                    @if ($product->discount > 0)
                        <h6 class="product-price" data-base-price="{{ $basePrice }}">
                            {{ \App\Helpers\PriceHelper::discountPrice($product->price, $product->discount, $product->discount_type) }}৳
                        </h6>
                        <h6><del>{{ $product->showPrice() }}</del></h6>
                    @else
                        <h6 class="product-price" data-base-price="{{ $basePrice }}">{{ $product->showPrice() }}
                        </h6>
                    @endif
                    <br>

                    @if ($product->measure == 1 && $product->measures->count() > 0)
                        <h6 class="measure-product">/ Per</h6> <br>
                        <select class="measure-select" class="form-control">
                            @foreach ($product->measures as $measure)
                                <option value="{{ $measure->value }}" data-price="{{ $measure->price }}">
                                    {{ $measure->label }}
                                </option>
                            @endforeach
                        </select>

                    @endif
                </div>

            @endif
        </div>
    </div>
</div>
