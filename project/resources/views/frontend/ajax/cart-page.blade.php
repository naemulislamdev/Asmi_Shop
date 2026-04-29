<form class="address-wrapper checkoutform" method="POST" id="userInfoForm">
    @csrf
    <input type="hidden" name="session_id" value="{{ session()->getId() }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');

        .btn-home {
            display: inline-block;
            background: linear-gradient(45deg, #1598a7, #1bb9cb);
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
        }

        /* loyality style */
        .loyalty-redeem-box {
            border: 1px dashed #fcd34d;
            background: #fffdf5;
            border-radius: 12px;
            padding: 16px 18px;
        }

        .loyalty-redeem-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .loyalty-icon {
            width: 36px;
            height: 36px;
            background: #fff8e1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .loyalty-title {
            font-size: 13px;
            font-weight: 600;
            color: #92400e;
            margin: 0;
        }

        .loyalty-balance {
            font-size: 13px;
            color: #78350f;
            margin: 2px 0 0;
        }

        .loyalty-balance strong {
            color: #b45309;
            font-size: 16px;
        }

        .loyalty-input-wrap {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .loyalty-input {
            flex: 1;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 14px;
            background: #fff;
            color: #1f2937;
            outline: none;
            transition: border-color 0.2s;
        }

        .loyalty-input:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.12);
        }

        .loyalty-apply-btn {
            padding: 9px 16px;
            background: #f59e0b;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.2s;
        }

        .loyalty-apply-btn:hover {
            background: #d97706;
        }

        .loyalty-error {
            font-size: 12px;
            color: #dc2626;
            margin: 6px 0 0;
            min-height: 16px;
        }

        .loyalty-hint {
            font-size: 12px;
            color: #9ca3af;
            margin: 6px 0 0;
        }

        .loyalty-insufficient {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #6b7280;
        }

        .loyalty-insufficient strong {
            color: #374151;
        }

        .checkout-page {
            padding: 30px 0;
            background: #f9fafb;
            min-height: 100vh;
        }

        /* ── Section Box ── */
        .checkout-box {
            background: #fff;
            border: 0.5px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .checkout-box-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            border-bottom: 0.5px solid #f0f1f3;
            background: #fafafa;
        }

        .checkout-box-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #e8f6f8;
            color: #1598a7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .checkout-box-header h6 {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin: 0;
        }

        .checkout-box-body {
            padding: 20px;
        }

        /* ── Inputs ── */
        .field-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .field-label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        .field-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            color: #111827;
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field-input:focus {
            border-color: #1598a7;
            box-shadow: 0 0 0 3px rgba(21, 152, 167, 0.1);
        }

        .field-input[readonly] {
            background: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }

        .field-error {
            font-size: 12px;
            color: #dc2626;
            margin: 2px 0 0;
        }

        /* ── Create Account Checkbox ── */
        .create-account-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: #f0fbfc;
            border: 1px dashed #1598a7;
            border-radius: 10px;
            cursor: pointer;
        }

        .create-account-toggle input[type="checkbox"] {
            display: none;
        }

        .create-account-toggle .check-box {
            width: 20px;
            height: 20px;
            border: 1.5px solid #1598a7;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: #fff;
            transition: background 0.2s;
        }

        .create-account-toggle:has(input:checked) .check-box {
            background: #1598a7;
            border-color: #1598a7;
        }

        .create-account-toggle:has(input:checked) .check-box svg {
            display: block;
        }

        .create-account-toggle .check-box svg {
            display: none;
        }

        .create-account-toggle span {
            font-size: 14px;
            color: #1598a7;
            font-weight: 500;
        }

        /* ── Shipping Options ── */
        .shipping-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .shipping-option-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            cursor: pointer;
            background: #fafafa;
            transition: border-color 0.2s, background 0.2s;
        }

        .shipping-option-card input[type="radio"] {
            display: none;
        }

        .shipping-option-card:has(input:checked) {
            border-color: #1598a7;
            background: #f0fbfc;
        }

        .shipping-icon {
            width: 34px;
            height: 34px;
            background: #e8f6f8;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1598a7;
            flex-shrink: 0;
        }

        .shipping-option-card:has(input:checked) .shipping-icon {
            background: #1598a7;
            color: #fff;
        }

        .shipping-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .shipping-title {
            font-size: 14px;
            font-weight: 500;
            color: #111827;
        }

        .shipping-subtitle {
            font-size: 12px;
            color: #6b7280;
        }

        .badge-free {
            font-size: 11px;
            font-weight: 600;
            background: #e9faf3;
            color: #15803d;
            border: 0.5px solid #bbf7d0;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .shipping-cost {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            font-family: "Rubik";
        }

        /* ── Payment Options ── */
        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .payment-option-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            cursor: pointer;
            background: #fafafa;
            transition: border-color 0.2s, background 0.2s;
        }

        .payment-option-card input[type="radio"] {
            display: none;
        }

        .payment-option-card:has(input:checked) {
            border-color: #1598a7;
            background: #f0fbfc;
        }

        .payment-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .payment-title {
            font-size: 14px;
            font-weight: 500;
            color: #111827;
        }

        .payment-subtitle {
            font-size: 12px;
            color: #6b7280;
        }

        .payment-check {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: transparent;
            flex-shrink: 0;
            transition: background 0.2s, color 0.2s;
        }

        .payment-option-card:has(input:checked) .payment-check {
            background: #1598a7;
            color: #fff;
        }

        /* ── Submit Button ── */
        .checkout-submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1598a7, #1bb9cb);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 8px;
        }

        .checkout-submit-btn:hover {
            opacity: 0.92;
        }

        /* ── Empty Cart ── */
        .empty-cart-box {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 14px;
            border: 0.5px solid #e5e7eb;
        }

        .empty-cart-box p {
            font-size: 16px;
            color: #6b7280;
            margin-top: 12px;
        }

        .checkout-page .checkout-box-body {
            font-family: "Rubik", sans-serif !important;
        }
    </style>

    <div class="container gs-cart-container checkout-page py-0 my-0">
        <div class="row gs-cart-row justify-content-center">

            @if (Session::has('cart'))
                @php $discount = 0; @endphp

                <div class="col-lg-7">

                    {{-- Personal Information --}}
                    <div class="checkout-box">
                        <div class="checkout-box-header">
                            <div class="checkout-box-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="8" r="4" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                            <h6>{{ __('Personal Information') }}</h6>
                        </div>
                        <div class="checkout-box-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="field-group">
                                        <label class="field-label" for="customer_name">
                                            {{ __('Full Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input class="field-input auto-save" id="customer_name" type="text"
                                            name="customer_name" placeholder="{{ __('Full Name') }}"
                                            value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                        @error('customer_name')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="field-group">
                                        <label class="field-label" for="phone">
                                            {{ __('Phone Number') }} <span class="text-danger">*</span>
                                        </label>
                                        <input class="field-input auto-save" id="phone" type="tel"
                                            placeholder="{{ __('Phone Number') }}" name="customer_phone"
                                            value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                                        <span id="phoneFeedback" class="field-error"></span>
                                        @error('customer_phone')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="field-group">
                                        <label class="field-label" for="email">
                                            {{ __('Email') }} <span class="text-muted"
                                                style="font-weight:400;">({{ __('Optional') }})</span>
                                        </label>
                                        <input class="field-input auto-save" id="email" type="email"
                                            name="customer_email" placeholder="{{ __('Enter Your Email') }}"
                                            value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                            {{ Auth::check() ? 'readonly' : '' }}>
                                        @error('customer_email')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="field-group">
                                        <label class="field-label" for="address">
                                            {{ __('Address') }} <span class="text-danger">*</span>
                                        </label>
                                        <input class="field-input auto-save" id="address" type="text"
                                            placeholder="{{ __('Address') }}" name="customer_address"
                                            value="{{ Auth::check() ? Auth::user()->address : '' }}">
                                        @error('customer_address')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="field-group">
                                        <label class="field-label" for="Order-Note">
                                            {{ __('Order Note') }}
                                            <span class="text-muted"
                                                style="font-weight:400;">({{ __('Optional') }})</span>
                                        </label>
                                        <input class="field-input" id="Order-Note" name="order_note" type="text"
                                            placeholder="{{ __('Any special instructions?') }}">
                                        @error('order_note')
                                            <span class="field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                @if (!Auth::check())
                                    <div class="col-lg-12">
                                        <label class="create-account-toggle" data-bs-toggle="collapse"
                                            data-bs-target="#show_passwords">
                                            <input type="checkbox" id="showca" name="create_account" value="1">
                                            <div class="check-box">
                                                <svg width="12" height="12" viewBox="0 0 12 12"
                                                    fill="none">
                                                    <path d="M2 6l3 3 5-5" stroke="#fff" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <span>{{ __('Create an account?') }}</span>
                                        </label>
                                    </div>

                                    <div class="col-12 collapse" id="show_passwords">
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div class="field-group">
                                                    <label class="field-label"
                                                        for="crpass">{{ __('Create Password') }}</label>
                                                    <input class="field-input" id="crpass" type="password"
                                                        placeholder="{{ __('Create Your Password') }}"
                                                        name="password">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="field-group">
                                                    <label class="field-label"
                                                        for="conpass">{{ __('Confirm Password') }}</label>
                                                    <input class="field-input" id="conpass" type="password"
                                                        placeholder="{{ __('Confirm Password') }}"
                                                        name="password_confirmation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Loyalty Points --}}
                    <div class="mb-3">
                        @php
                            $totalLoyaltyPoints = auth()->user() ? (int) round(auth()->user()->wallet_points) : 0;
                        @endphp

                        <div class="loyalty-redeem-box">
                            <div class="loyalty-redeem-header">
                                <div class="loyalty-icon">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"
                                            fill="#f59e0b" stroke="#f59e0b" stroke-width="1"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="loyalty-title">Reward Points</p>
                                    <p class="loyalty-balance">
                                        Balance: <strong>{{ number_format($totalLoyaltyPoints) }} pts</strong>
                                    </p>
                                </div>
                            </div>

                            @if ($totalLoyaltyPoints >= 100)
                                <div class="loyalty-input-wrap">
                                    <input type="number" name="use_points" id="use_points" class="loyalty-input"
                                        min="100" max="{{ $totalLoyaltyPoints }}"
                                        totalPrice="{{ $totalPrice }}"
                                        placeholder="Enter points to redeem (min 100)">
                                    <button type="button" class="loyalty-apply-btn" onclick="applyMax()">Withdraw
                                        All Points</button>
                                </div>
                                <p id="points-error" class="loyalty-error"></p>
                                <p class="loyalty-hint">1 point = 1 BDT &nbsp;·&nbsp; Min: 100 &nbsp;·&nbsp; Max:
                                    {{ number_format($totalLoyaltyPoints) }} pts</p>
                            @else
                                <div class="loyalty-insufficient">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="10" stroke="#9ca3af"
                                            stroke-width="1.5" />
                                        <path d="M12 8v4M12 16h.01" stroke="#9ca3af" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                    You need at least <strong>100 points</strong> to Withdraw. You have
                                    {{ $totalLoyaltyPoints }} pts.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Shipping Method --}}
                    @php
                        $shipping = App\Models\Shipping::where('user_id', 0)->get();
                        $vendor_id = 0;
                    @endphp

                    <div class="checkout-box">
                        <div class="checkout-box-header">
                            <div class="checkout-box-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z" stroke="currentColor"
                                        stroke-width="1.5" stroke-linejoin="round" />
                                    <circle cx="5.5" cy="18.5" r="1.5" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle cx="18.5" cy="18.5" r="1.5" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </div>
                            <h6>{{ __('Shipping Method') }}</h6>
                        </div>
                        <div class="checkout-box-body">
                            <div class="shipping-options">
                                @forelse($shipping as $data)
                                    <label class="shipping-option-card" for="free-shepping{{ $data->id }}">
                                        <input type="radio" class="shipping" ref="{{ $vendor_id }}"
                                            data-price="{{ round($data->price * $curr->value, 2) }}"
                                            view="{{ $curr->sign }}{{ round($data->price * $curr->value, 2) }}"
                                            data-form="{{ $data->title }}" id="free-shepping{{ $data->id }}"
                                            name="shipping[{{ $vendor_id }}]" value="{{ $data->id }}"
                                            {{ $loop->first ? 'checked' : '' }}>

                                        <div class="shipping-icon">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                <path d="M1 3h15v13H1zM16 8h4l3 3v5h-7V8z" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linejoin="round" />
                                                <circle cx="5.5" cy="18.5" r="1.5" stroke="currentColor"
                                                    stroke-width="1.5" />
                                                <circle cx="18.5" cy="18.5" r="1.5" stroke="currentColor"
                                                    stroke-width="1.5" />
                                            </svg>
                                        </div>

                                        <div class="shipping-info">
                                            <span class="shipping-title">{{ $data->title }}</span>
                                            @if ($data->subtitle)
                                                <span class="shipping-subtitle">{{ $data->subtitle }}</span>
                                            @endif
                                        </div>

                                        <div>
                                            @if ($data->price == 0)
                                                <span class="badge-free">Free</span>
                                            @else
                                                <span class="shipping-cost">
                                                    +{{ $curr->sign }}{{ round($data->price * $curr->value, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                    </label>
                                @empty
                                    <p class="text-muted small">{{ __('No Shipping Method Available') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="checkout-box">
                        <div class="checkout-box-header">
                            <div class="checkout-box-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="5" width="20" height="14" rx="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path d="M2 10h20" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                            </div>
                            <h6>{{ __('Payment Method') }}</h6>
                        </div>
                        <div class="checkout-box-body">
                            <div class="payment-options">
                                @foreach ($gateways as $gt)
                                    @if ($gt->checkout == 1)
                                        @if ($gt->type == 'manual')
                                            @if ($digital == 0)
                                                <label class="payment-option-card payment"
                                                    for="pl{{ $gt->id }}" data-show="{{ $gt->showForm() }}"
                                                    data-form="{{ $gt->showCheckoutLink() }}"
                                                    data-href="{{ route('front.load.payment', ['slug1' => $gt->showKeyword(), 'slug2' => $gt->id]) }}">
                                                    <input type="radio" id="pl{{ $gt->id }}"
                                                        name="payment_1">
                                                    <div class="payment-info">
                                                        <span class="payment-title">{{ $gt->title }}</span>
                                                        @if ($gt->subtitle)
                                                            <span class="payment-subtitle">{{ $gt->subtitle }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="payment-check">
                                                        <svg width="12" height="12" viewBox="0 0 24 24"
                                                            fill="none">
                                                            <path d="M5 13l4 4L19 7" stroke="currentColor"
                                                                stroke-width="2.5" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </div>
                                                </label>
                                            @endif
                                        @else
                                            <label class="payment-option-card payment" for="pl{{ $gt->id }}"
                                                data-val="{{ $gt->keyword }}" data-show="{{ $gt->showForm() }}"
                                                data-form="{{ $gt->showCheckoutLink() }}"
                                                data-href="{{ route('front.load.payment', ['slug1' => $gt->showKeyword(), 'slug2' => $gt->id]) }}">
                                                <input type="radio" id="pl{{ $gt->id }}" name="payment_1">
                                                <div class="payment-info">
                                                    <span class="payment-title">{{ $gt->name }}</span>
                                                    @if ($gt->information != null)
                                                        <span
                                                            class="payment-subtitle">{{ $gt->getAutoDataText() }}</span>
                                                    @endif
                                                </div>
                                                <div class="payment-check">
                                                    <svg width="12" height="12" viewBox="0 0 24 24"
                                                        fill="none">
                                                        <path d="M5 13l4 4L19 7" stroke="currentColor"
                                                            stroke-width="2.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                            </label>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                            <div class="transection-wrapper pay-area mt-3"></div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="checkout-submit-btn">
                        {{ __('Complete Order') }}
                    </button>

                    {{-- Hidden fields --}}
                    <input type="hidden" name="dp" value="{{ $digital }}">
                    <input type="hidden" id="input_tax" name="tax" value="">
                    <input type="hidden" id="input_tax_type" name="tax_type" value="">
                    <input type="hidden" name="totalQty" value="{{ $totalQty }}">
                    <input type="hidden" name="currency_sign" value="{{ $curr->sign }}">
                    <input type="hidden" name="currency_name" value="{{ $curr->name }}">
                    <input type="hidden" name="currency_value" value="{{ $curr->value }}">

                    @if (Session::has('coupon_total'))
                        <input type="hidden" name="total" id="grandtotal"
                            value="{{ round($totalPrice * $curr->value, 2) }}">
                        <input type="hidden" id="tgrandtotal" value="{{ $totalPrice }}">
                    @elseif (Session::has('coupon_total1'))
                        <input type="hidden" name="total" id="grandtotal"
                            value="{{ preg_replace(' /[^0-9,.]/', '', Session::get('coupon_total1')) }}">
                        <input type="hidden" id="tgrandtotal"
                            value="{{ preg_replace(' /[^0-9,.]/', '', Session::get('coupon_total1')) }}">
                    @else
                        <input type="hidden" name="total" id="grandtotal"
                            value="{{ round($totalPrice * $curr->value, 2) }}">
                        <input type="hidden" id="tgrandtotal" value="{{ round($totalPrice * $curr->value, 2) }}">
                    @endif

                    <input type="hidden" id="original_tax" value="0">
                    <input type="hidden" id="wallet-price" name="wallet_price" value="0">
                    <input type="hidden" id="ttotal"
                        value="{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0' }}">
                    <input type="hidden" name="coupon_code" id="coupon_code"
                        value="{{ Session::has('coupon_code') ? Session::get('coupon_code') : '' }}">
                    <input type="hidden" name="coupon_discount" id="coupon_discount"
                        value="{{ Session::has('coupon') ? Session::get('coupon') : '' }}">
                    <input type="hidden" name="coupon_id" id="coupon_id"
                        value="{{ Session::has('coupon') ? Session::get('coupon_id') : '' }}">
                    <input type="hidden" name="user_id" id="user_id"
                        value="{{ Auth::guard('web')->check() ? Auth::guard('web')->user()->id : '' }}">

                </div>
            @else
                <div class="col-xl-8">
                    <div class="empty-cart-box">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                            style="color:#d1d5db;">
                            <path
                                d="M6 2H4a1 1 0 00-1 1v1a1 1 0 001 1h1l1.68 8.39A2 2 0 008.6 15h8.81a2 2 0 001.96-1.61L20.5 7H6"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <circle cx="9" cy="19" r="1.5" stroke="currentColor"
                                stroke-width="1.5" />
                            <circle cx="17" cy="19" r="1.5" stroke="currentColor"
                                stroke-width="1.5" />
                        </svg>
                        <p>{{ __('Your cart is empty. Add some products first!') }}</p>
                        <a href="{{ route('front.index') }}" class="btn-home">
                            Go Shopping
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</form>
@section('script')
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="https://js.stripe.com/v3/"></script>


    <script type="text/javascript">
        // under input field
        $('.payment:first').children('input').prop('checked', true);
        $('.checkoutform').attr('action', $('.payment:first').attr('data-form'));
        $(".pay-area").load($('.payment:first').data('href'));

        var show = $('.payment:first').data('show');
        if (show != 'no') {
            $('.pay-area').removeClass('d-none');
        } else {
            $('.pay-area').addClass('d-none');
        }
    </script>



    <script type="text/javascript">
        var coup = 0;
        var pos = {{ $gs->currency_format }};
        let mship = 0;
        let mpack = 0;


        var ftotal = parseFloat($('#grandtotal').val());
        ftotal = parseFloat(ftotal).toFixed(2);

        if (pos == 0) {
            $('#final-cost').html('{{ $curr->sign }}' + ftotal)
        } else {
            $('#final-cost').html(ftotal + '{{ $curr->sign }}')
        }
        $('#grandtotal').val(ftotal);

        let original_tax = 0;

        $(document).ready(function() {
            getShipping();
            getPacking();

            let country_id = $('#select_country').val();
            let state_id = $('#state_id').val();
            let is_state = $('#is_state').val();
            let state_url = $('#state_url').val();


            if (is_state == 1) {
                if (is_state == 1) {
                    $('.select_state').removeClass('d-none');
                    $.get(state_url, function(response) {
                        $('#show_state').html(response.data);
                        tax_submit(country_id, response.state);
                    });

                } else {
                    tax_submit(country_id, state_id);
                    hide_state();
                }
            } else {
                tax_submit(country_id, state_id);
                hide_state();
            }
        });


        function hide_state() {
            $('.select_state').addClass('d-none');
        }


        function tax_submit(country_id, state_id) {

            $('.gocover').show();
            var total = $("#ttotal").val();
            var ship = 0;
            $.ajax({
                type: "GET",
                url: mainurl + "/country/tax/check",

                data: {
                    state_id: state_id,
                    country_id: country_id,
                    total: total,
                    shipping_cost: ship
                },
                success: function(data) {

                    $('#grandtotal').val(data[0]);
                    $('#tgrandtotal').val(data[0]);
                    $('#original_tax').val(data[1]);
                    $('.tax_show').removeClass('d-none');
                    $('#input_tax').val(data[11]);
                    $('#input_tax_type').val(data[12]);
                    $('.original_tax').html(parseFloat(data[1]) + "%");
                    var ttotal = parseFloat($('#grandtotal').val());
                    var tttotal = parseFloat($('#grandtotal').val()) + (parseFloat(mship) + parseFloat(mpack));
                    ttotal = parseFloat(ttotal).toFixed(2);
                    tttotal = parseFloat(tttotal).toFixed(2);
                    $('#grandtotal').val(data[0] + parseFloat(mship) + parseFloat(mpack));
                    if (pos == 0) {
                        $('#final-cost').html('{{ $curr->sign }}' + tttotal);
                        $('.total-cost-dum #total-cost').html('{{ $curr->sign }}' + ttotal);
                    } else {
                        $('#total-cost').html('');
                        $('#final-cost').html(tttotal + '{{ $curr->sign }}');
                        $('.total-cost-dum #total-cost').html(ttotal + '{{ $curr->sign }}');
                    }
                    $('.gocover').hide();
                }
            });
        }


        $('.shipping').on('click', function() {
            getShipping();

            let ref = $(this).attr('ref');
            let view = $(this).attr('view');
            let title = $(this).attr('data-form');
            $('#shipping_text' + ref).html(title + '+' + view);
            var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
            ttotal = parseFloat(ttotal).toFixed(2);
            if (pos == 0) {
                $('#final-cost').html('{{ $curr->sign }}' + ttotal);
            } else {
                $('#final-cost').html(ttotal + '{{ $curr->sign }}');
            }
            $('#grandtotal').val(ttotal);
            $('#multi_shipping_id').val($(this).val());

        })


        $('.packing').on('click', function() {
            getPacking();
            let ref = $(this).attr('ref');
            let view = $(this).attr('view');
            let title = $(this).attr('data-form');
            $('#packing_text' + ref).html(title + '+' + view);
            var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
            ttotal = parseFloat(ttotal).toFixed(2);
            if (pos == 0) {
                $('#final-cost').html('{{ $curr->sign }}' + ttotal);
            } else {
                $('#final-cost').html(ttotal + '{{ $curr->sign }}');
            }
            $('#grandtotal').val(ttotal);
            $('#multi_packaging_id').val($(this).val());
        })


        function getShipping() {
            mship = 0;
            $('.shipping').each(function() {
                if ($(this).is(':checked')) {
                    mship += parseFloat($(this).attr('data-price'));
                }
                $('.shipping_cost_view').html('{{ $curr->sign }}' + mship);
            });
        }

        function getPacking() {
            mpack = 0;
            $('.packing').each(function() {
                if ($(this).is(':checked')) {
                    mpack += parseFloat($(this).attr('data-price'));
                }
                $('.packing_cost_view').html('{{ $curr->sign }}' + mpack);
            });
        }
        $(document).on("click", "#check_coupon", function() {
            var val = $("#code").val();
            //console.log(val);

            var total = $("#ttotal").val();
            var ship = 0;
            $.ajax({
                type: "GET",
                url: mainurl + "/carts/coupon/check",
                data: {
                    code: val,
                    total: total,
                    shipping_cost: ship
                },
                success: function(data) {
                    if (data == 0) {
                        toastr.error('{{ __('Coupon not found') }}');
                        $("#code").val("");
                    } else if (data == 2) {
                        toastr.error('{{ __('Coupon already have been taken') }}');
                        $("#code").val("");
                    } else if (data == 3) {
                        toastr.error('{{ __('Coupon unable') }}');
                        $("#code").val("");
                    } else {
                        $("#check-coupon-form").toggle();
                        $(".discount-bar").removeClass('d-none');

                        if (pos == 0) {
                            $('.total-cost-dum #total-cost').html('{{ $curr->sign }}' + data[0]);
                            $('#discount').html('{{ $curr->sign }}' + data[2]);
                        } else {
                            $('.total-cost-dum #total-cost').html(data[0]);
                            $('#discount').html(data[2] + '{{ $curr->sign }}');
                        }
                        $("#coupon_id").val(data[3]);
                        $('#grandtotal').val(data[0]);
                        $('#tgrandtotal').val(data[0]);
                        $('#coupon_code').val(data[1]);
                        $('#coupon_discount').val(data[2]);
                        if (data[4] != 0) {
                            $('.dpercent').html('(' + data[4] + ')');
                        } else {
                            $('.dpercent').html('');
                        }


                        var ttotal = data[6] + parseFloat(mship) + parseFloat(mpack);
                        ttotal = parseFloat(ttotal);
                        if (ttotal % 1 != 0) {
                            ttotal = ttotal.toFixed(2);
                        }

                        if (pos == 0) {
                            $('.total-amount').html('{{ $curr->sign }}' + ttotal)
                        } else {
                            $('.total-amount').html(ttotal + '{{ $curr->sign }}')
                        }
                        toastr.success(lang.coupon_found);
                        $("#code").val("");
                    }
                }
            });
            return false;
        });

        $('.payment').on('click', function() {

            if ($(this).data('val') == 'paystack') {
                $('.checkoutform').attr('id', 'step1-form');
            } else if ($(this).data('val') == 'mercadopago') {
                $('.checkoutform').attr('id', 'mercadopago');
                checkONE = 1;
            } else {
                $('.checkoutform').attr('id', '');
            }
            $('.checkoutform').attr('action', $(this).attr('data-form'));
            $('.payment').removeClass('active');

            var show = $(this).attr('data-show');
            if (show != 'no') {
                $('.pay-area').removeClass('d-none');
            } else {
                $('.pay-area').addClass('d-none');
            }
            $($('#v-pills-tabContent .tap-pane').removeClass('active show'));
            $(".pay-area").addClass('active show').load($(this).attr(
                'data-href'));
        })
    </script>
    <script>
        document.getElementById('phone').addEventListener('input', function() {
            const phoneInput = this.value;
            const phoneFeedback = document.getElementById('phoneFeedback');
            const regex = /^(01[3-9]\d{8})$/;

            if (phoneInput === '') {
                phoneFeedback.textContent = '';
            } else if (!regex.test(phoneInput)) {
                phoneFeedback.classList.add('text-danger');
                phoneFeedback.textContent = 'Please enter a valid Bangladeshi phone number (e.g. 0171XXXXXXX)';
            } else {
                phoneFeedback.textContent = 'Valid phone number!';
                phoneFeedback.classList.remove('text-danger');
                phoneFeedback.classList.add('text-success');
            }
        });

        // Also validate when the field loses focus
        document.getElementById('phone').addEventListener('blur', function() {
            const phoneInput = this.value;
            const phoneFeedback = document.getElementById('phoneFeedback');
            const regex = /^(01[3-9]\d{8})$/;

            if (phoneInput === '') {
                phoneFeedback.textContent = 'Phone number is required';
            } else if (!regex.test(phoneInput)) {
                phoneFeedback.textContent = 'Please enter a valid Bangladeshi phone number (e.g. 0171XXXXXXX)';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            let typingTimer;
            let doneTypingInterval = 1000; // Time in milliseconds (1 second)

            $(".auto-save").on("input", function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(saveUserData, doneTypingInterval);
            });

            function saveUserData() {
                let formData = $("#userInfoForm").serialize();

                $.ajax({
                    url: "{{ route('front.save.user.info') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            console.log("Data auto-saved successfully!");
                        } else {
                            console.log("Failed to save data.");
                        }
                    },
                    error: function(xhr) {
                        console.log("Error: ", xhr.responseText);
                    }
                });
            }
        });
    </script>

    <script>
        const input = document.getElementById('use_points');

        function applyMax() {
            if (!input) return;
            input.value = Math.floor(parseFloat(input.max)); // "236.75" → 236.75 → 236... কিন্তু আমরা চাই 237
            input.dispatchEvent(new Event('input'));
        }


        input?.addEventListener('input', function() {
            let max = parseInt(this.max); // 237 ✅
            let value = parseInt(this.value) || 0;
            let totalPrice = parseFloat(this.getAttribute('totalPrice')) || 0;

            if (value > max) {
                this.value = max;
                value = max;
            }

            let finalTotal = Math.max(0, totalPrice - value);
            document.getElementById('final_total').innerText = finalTotal.toFixed(2);
        });



        input?.addEventListener('blur', function() {
            let value = parseInt(this.value) || 0;
            const errorEl = document.getElementById('points-error');

            if (value > 0 && value < 100) {
                errorEl.textContent = 'Minimum 100 points required to redeem.';
                toastr.error('Minimum 100 points required to redeem.');
                this.value = '';
            } else {
                errorEl.textContent = '';
            }
        });
    </script>
@endsection
