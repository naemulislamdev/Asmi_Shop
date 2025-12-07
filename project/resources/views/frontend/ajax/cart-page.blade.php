<form class="address-wrapper checkoutform" method="POST">
    @csrf
    <div class="container gs-cart-container">

        <div class="row gs-cart-row">
            <style>
                .gs-checkout-wrapper {
                    padding: 10px 0;
                }

                .gs-checkout-wrapper .address-wrapper .input-wrapper .input-cls {
                    padding: 10px 10px;
                    font-size: 16px;
                    line-height: 100%;
                }

                .accordion-button {
                    padding: 0px 6px !important;
                }

                .accordion-button:not(.collapsed) {
                    background-color: #f8f7f7;
                }

                .accordion-button:focus {
                    border-color: #f8f7f7;
                    outline: 0;
                }
            </style>

            @if (Session::has('cart'))

                @php
                    $discount = 0;
                @endphp

                <div class="col-lg-7 mx-auto">
                    <div class="gs-checkout-wrapper">
                        <div class="container">
                            <!-- address-->
                            <div class="address-wrapper">
                                <div class="row gy-4 mb-3">
                                    <div class="col-lg-12 wow fadeInUp" data-wow-delay=".2s">
                                        <!-- personal information -->
                                        <div class="mb-40">
                                            <h4 class="form-title">@lang('Personal Information')</h4>
                                        </div>

                                        <!-- Billing Details -->
                                        <div class="mb-40">
                                            <div class="row g-4">
                                                <div class="col-lg-6">
                                                    <div class="input-wrapper">
                                                        <label class="label-cls" for="customer_name">@lang('Name')
                                                            <span class="text-danger">*</span></label>
                                                        <input class="input-cls" id="customer_name" type="text"
                                                            name="customer_name" placeholder="@lang('Full Name')"
                                                            value="{{ Auth::check() ? Auth::user()->name : '' }}">
                                                        @error('customer_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="input-wrapper">
                                                        <label class="label-cls" for="phone">
                                                            @lang('Phone Number') <span class="text-danger">*</span>
                                                        </label>
                                                        <input class="input-cls" id="phone" type="tel"
                                                            placeholder="@lang('Phone Number')" name="customer_phone"
                                                            value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                                                        <span id="phoneFeedback" class="small text-danger"></span>
                                                        @error('customer_phone')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="input-wrapper">
                                                        <label class="label-cls" for="email">@lang('Email')
                                                            (Optional)</label>
                                                        <input class="input-cls" id="email" type="email"
                                                            name="customer_email" placeholder="@lang('Enter Your Email')"
                                                            value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                                            {{ Auth::check() ? 'readonly' : '' }}>
                                                        @error('customer_email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="input-wrapper">
                                                        <label class="label-cls" for="address">
                                                            @lang('Address') <span class="text-danger">*</span>
                                                        </label>
                                                        <input class="input-cls" id="address" type="text"
                                                            placeholder="@lang('Address')" name="customer_address"
                                                            value="{{ Auth::check() ? Auth::user()->address : '' }}">
                                                        @error('customer_address')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="input-wrapper">
                                                        <label class="label-cls" for="Order-Note">
                                                            @lang('Order Note')
                                                        </label>
                                                        <input class="input-cls" id="Order-Note" name="order_note"
                                                            type="text" placeholder="@lang('Order note (Optional)')">
                                                        @error('order_note')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-4">

                                            @if (!Auth::check())
                                                <div class="col-lg-12">
                                                    <div class="gs-checkbox-wrapper" data-bs-toggle="collapse"
                                                        data-bs-target="#show_passwords" aria-expanded="false"
                                                        aria-controls="show_passwords" role="region">
                                                        <input type="checkbox" id="showca">
                                                        <label class="icon-label" for="showca">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                height="12" viewBox="0 0 12 12" fill="none">
                                                                <path d="M10 3L4.5 8.5L2 6" stroke="#EE1243"
                                                                    stroke-width="1.6666" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                        </label>
                                                        <label for="showca">@lang('Create an account ?')</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 collapse" id="show_passwords">
                                                    <div class="row gy-4">

                                                        <div class="col-lg-6">
                                                            <div class="input-wrapper">
                                                                <label class="label-cls" for="crpass">
                                                                    @lang('Create Password')
                                                                </label>
                                                                <input class="input-cls" id="crpass"
                                                                    type="password" placeholder="@lang('Create Your Password')">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="input-wrapper">
                                                                <label class="label-cls" for="conpass">
                                                                    @lang('Confirm Password')
                                                                </label>
                                                                <input class="input-cls" id="conpass"
                                                                    type="password" placeholder="@lang('Confirm Password')">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $shipping = App\Models\Shipping::where('user_id', 0)->get();
                                $vendor_id = 0;
                            @endphp
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" mb-3 bg-light-white p-4">
                                        <span class="label mr-2">
                                            <b>{{ __('Shipping Method :') }}</b>
                                        </span>
                                        <div class="packeging-area">
                                            <div class="summary-inner-box">
                                                <div class="inputs-wrapper">
                                                    @forelse($shipping as $data)
                                                        <div class="gs-radio-wrapper">
                                                            <input type="radio" class="shipping"
                                                                ref="{{ $vendor_id }}"
                                                                data-price="{{ round($data->price * $curr->value, 2) }}"
                                                                view="{{ $curr->sign }}{{ round($data->price * $curr->value, 2) }}"
                                                                data-form="{{ $data->title }}"
                                                                id="free-shepping{{ $data->id }}"
                                                                name="shipping[{{ $vendor_id }}]"
                                                                value="{{ $data->id }}"
                                                                {{ $loop->first ? 'checked' : '' }}>
                                                            <label class="icon-label"
                                                                for="free-shepping{{ $data->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20"
                                                                    fill="none">
                                                                    <rect x="0.5" y="0.5" width="19"
                                                                        height="19" rx="9.5"
                                                                        fill="#FDFDFD" />
                                                                    <rect x="0.5" y="0.5" width="19"
                                                                        height="19" rx="9.5"
                                                                        stroke="#EE1243" />
                                                                    <circle cx="10" cy="10" r="4"
                                                                        fill="#EE1243" />
                                                                </svg>
                                                            </label>

                                                            <label for="free-shepping{{ $data->id }}">
                                                                {{ $data->title }}
                                                                @if ($data->price != 0)
                                                                    +
                                                                    {{ $curr->sign }}{{ round($data->price * $curr->value, 2) }}
                                                                @endif
                                                                <small>{{ $data->subtitle }}</small>
                                                            </label>
                                                        </div>
                                                    @empty
                                                        <p>
                                                            @lang('No Shipping Method Available')
                                                        </p>
                                                    @endforelse

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="select-payment-list-wrapper">
                                        <h5 class="title">@lang('Select payment Method')</h5>

                                        <div class="list-wrapper">
                                            @foreach ($gateways as $gt)
                                                @if ($gt->checkout == 1)
                                                    @if ($gt->type == 'manual')
                                                        @if ($digital == 0)
                                                            <!-- single payment input -->
                                                            <div class="gs-radio-wrapper payment"
                                                                data-show="{{ $gt->showForm() }}"
                                                                data-form="{{ $gt->showCheckoutLink() }}"
                                                                data-href="{{ route('front.load.payment', ['slug1' => $gt->showKeyword(), 'slug2' => $gt->id]) }}">
                                                                <input type="radio" id="pl{{ $gt->id }}"
                                                                    name="payment_1">
                                                                <label class="icon-label"
                                                                    for="pl{{ $gt->id }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="20" height="20"
                                                                        viewBox="0 0 20 20" fill="none">
                                                                        <rect x="0.5" y="0.5" width="19"
                                                                            height="19" rx="9.5"
                                                                            fill="#FDFDFD" />
                                                                        <rect x="0.5" y="0.5" width="19"
                                                                            height="19" rx="9.5"
                                                                            stroke="#EE1243" />
                                                                        <circle cx="10" cy="10" r="4"
                                                                            fill="#EE1243" />
                                                                    </svg>
                                                                </label>
                                                                <label class="label-wrapper"
                                                                    for="pl{{ $gt->id }}">
                                                                    <span
                                                                        class="label-title">{{ $gt->title }}</span>
                                                                    <span
                                                                        class="label-subtitle">{{ $gt->subtitle }}</span>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="gs-radio-wrapper payment"
                                                            data-val="{{ $gt->keyword }}"
                                                            data-show="{{ $gt->showForm() }}"
                                                            data-form="{{ $gt->showCheckoutLink() }}"
                                                            data-href="{{ route('front.load.payment', ['slug1' => $gt->showKeyword(), 'slug2' => $gt->id]) }}">
                                                            <input type="radio" id="pl{{ $gt->id }}"
                                                                name="payment_1">
                                                            <label class="icon-label" for="pl{{ $gt->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20"
                                                                    fill="none">
                                                                    <rect x="0.5" y="0.5" width="19"
                                                                        height="19" rx="9.5"
                                                                        fill="#FDFDFD" />
                                                                    <rect x="0.5" y="0.5" width="19"
                                                                        height="19" rx="9.5"
                                                                        stroke="#EE1243" />
                                                                    <circle cx="10" cy="10" r="4"
                                                                        fill="#EE1243" />
                                                                </svg>
                                                            </label>
                                                            <label class="label-wrapper" for="pl{{ $gt->id }}">
                                                                <span class="label-title"> {{ $gt->name }}</span>
                                                                @if ($gt->information != null)
                                                                    <span
                                                                        class="label-subtitle">{{ $gt->getAutoDataText() }}</span>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="transection-wrapper pay-area"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-summary-btn">
                                <button type="submit" class="template-btn w-100">@lang('Proceed to Checkout')</button>
                            </div>

                            <input type="hidden" name="dp" value="{{ $digital }}">
                            <input type="hidden" id="input_tax" name="tax" value="">
                            <input type="hidden" id="input_tax_type" name="tax_type" value="">
                            <input type="hidden" name="totalQty" value="{{ $totalQty }}">

                            <input type="hidden" name="currency_sign" value="{{ $curr->sign }}">
                            <input type="hidden" name="currency_name" value="{{ $curr->name }}">
                            <input type="hidden" name="currency_value" value="{{ $curr->value }}">
                            @php
                            @endphp
                            @if (Session::has('coupon_total'))
                                <input type="hidden" name="total" id="grandtotal"
                                    value="{{ round($totalPrice * $curr->value, 2) }}">
                                <input type="hidden" id="tgrandtotal" value="{{ $totalPrice }}">
                            @elseif(Session::has('coupon_total1'))
                                <input type="hidden" name="total" id="grandtotal"
                                    value="{{ preg_replace(' /[^0-9,.]/', '', Session::get('coupon_total1')) }}">
                                <input type="hidden" id="tgrandtotal"
                                    value="{{ preg_replace(' /[^0-9,.]/', '', Session::get('coupon_total1')) }}">
                            @else
                                <input type="hidden" name="total" id="grandtotal"
                                    value="{{ round($totalPrice * $curr->value, 2) }}">
                                <input type="hidden" id="tgrandtotal"
                                    value="{{ round($totalPrice * $curr->value, 2) }}">
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
                    </div>
                </div>
            @else
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <div class="card border py-4">
                        <div class="card-body">
                            <h4 class="text-center">{{ __('Cart is Empty!! Add some products in your Cart') }}</h4>
                        </div>
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
@endsection
