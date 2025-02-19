<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="GeniusCart-New - Multivendor Ecommerce system">
    <meta name="author" content="GeniusOcean">
    <title>{{ $gs->title }}-@lang('checkout')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/' . $gs->favicon) }}" />
    <!-- Google Font -->
    @if ($default_font->font_value)
        <link
            href="https://fonts.googleapis.com/css?family={{ $default_font->font_value }}:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
            rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700;800;900&display=swap"
            rel="stylesheet">
    @endif
    <link rel="stylesheet"
        href="{{ asset('assets/front/css/styles.php?color=' . str_replace('#', '', $gs->colors) . '&header_color=' . $gs->header_color) }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/custom.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">
    @if ($default_font->font_family)
        <link rel="stylesheet" id="colorr"
            href="{{ asset('assets/front/css/font.php?font_familly=' . $default_font->font_family) }}">
    @else
        <link rel="stylesheet" id="colorr"
            href="{{ asset('assets/front/css/font.php?font_familly=' . ' Open Sans') }}">
    @endif
</head>

<body>
    <div class="gs-checkout-wrapper">
        <div class="container">
            <form action="" method="POST" class="checkoutform">
                <div class="row">
                    <div class="col-lg-8 order-last order-lg-first">
                        @include('includes.form-success')
                        @include('includes.form-error')
                        {{ csrf_field() }}
                        <div class="select-payment-list-wrapper">
                            <h5 class="title">@lang('Select payment Method')</h5>

                            <div class="list-wrapper mb-4">
                                @foreach ($gateways as $gt)
                                    @if ($gt->type == 'manual')
                                        @if ($order->dp == 0)
                                            <!-- single payment input -->
                                            <div class="gs-radio-wrapper payment" data-show="{{ $gt->showForm() }}"
                                                data-form="{{ $gt->showApiCheckoutLink() }}"
                                                data-href="{{ route('front.load.payment', ['slug1' => $gt->showKeyword(), 'slug2' => $gt->id]) }}">
                                                <input type="radio" id="pl{{ $gt->id }}" name="payment_1">
                                                <label class="icon-label" for="pl{{ $gt->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 20 20" fill="none">
                                                        <rect x="0.5" y="0.5" width="19" height="19"
                                                            rx="9.5" fill="#FDFDFD" />
                                                        <rect x="0.5" y="0.5" width="19" height="19"
                                                            rx="9.5" stroke="#EE1243" />
                                                        <circle cx="10" cy="10" r="4" fill="#EE1243" />
                                                    </svg>
                                                </label>
                                                <label class="label-wrapper" for="pl{{ $gt->id }}">
                                                    <span class="label-title">{{ $gt->title }}</span>
                                                    <span class="label-subtitle">{{ $gt->subtitle }}</span>
                                                </label>
                                            </div>
                                        @endif
                                    @else
                                        <div class="gs-radio-wrapper payment" data-val="{{ $gt->keyword }}"
                                            data-show="{{ $gt->showForm() }}"
                                            data-form="{{ $gt->showApiCheckoutLink() }}"
                                            data-href="{{ route('front.load.payment', ['slug1' => $gt->showKeyword(), 'slug2' => $gt->id]) }}">
                                            <input type="radio" id="pl{{ $gt->id }}" name="payment_1">
                                            <label class="icon-label" for="pl{{ $gt->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <rect x="0.5" y="0.5" width="19" height="19" rx="9.5"
                                                        fill="#FDFDFD" />
                                                    <rect x="0.5" y="0.5" width="19" height="19" rx="9.5"
                                                        stroke="#EE1243" />
                                                    <circle cx="10" cy="10" r="4" fill="#EE1243" />
                                                </svg>
                                            </label>
                                            <label class="label-wrapper" for="pl{{ $gt->id }}">
                                                <span class="label-title"> {{ $gt->name }}</span>
                                                @if ($gt->information != null)
                                                    <span class="label-subtitle">{{ $gt->getAutoDataText() }}</span>
                                                @endif
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="transection-wrapper pay-area mb-4 d-none">
                            </div>
                            <input type="hidden" id="preamount"
                                value="{{ $order->pay_amount * $order->currency_value }}">
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                            <input type="hidden" name="email" value="{{ $order->customer_email }}">
                            <input type="hidden" name="ref_id" id="ref_id" value="">
                            <button type="submit" class="template-btn inline-block">submit</button>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="summary-box">
                            <div class="summary-inner-box">
                                <h4 class="title">{{ $langg->lang127 }}</h4>
                                <div class="total-price">
                                    <h4 class="form-title">@lang('Total Order Amount')</h4>

                                    <p>
                                        @if ($gs->currency_format == 0)
                                            <span id="total-cost">{{ $order->currency_sign }}<span
                                                    class="total_price">
                                                    {{ $order->pay_amount * $order->currency_value }}</span></span>
                                        @else
                                            <span id="total-cost"> <span class="total_price">
                                                    {{ $order->pay_amount * $order->currency_value }}</span>{{ $order->currency_sign }}</span>
                                        @endif
                                    </p>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        var mainurl = "{{ url('/') }}";
        var gs = {!! json_encode($gs) !!};
    </script>
    <!-- Include Scripts -->
    <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="//voguepay.com/js/voguepay.js"></script>


    @php
        $curr = App\Models\Currency::where('sign', '=', $order->currency_sign)->firstOrFail();
    @endphp
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


        $(document).on('click', '.shipping', function() {
            grandTotal();
        });

        $(document).on('click', '.packing', function() {
            grandTotal();
        });

        let extra = 0;

        function grandTotal() {
            $('#grandTotal').val($('#preamount').val());
            let total = parseFloat($('#grandTotal').val());
            console.log(total);
            let shipping_charge = parseFloat($('.shipping:checked').attr('data'));
            let packing_charge = parseFloat($('.packing:checked').attr('data'));
            extra = shipping_charge + packing_charge;
            total += shipping_charge + packing_charge;

            $('.total_price').html(parseFloat(total).toFixed(2));
            $('#grandTotal').val(parseFloat(total).toFixed(2))
        }


        $(document).on('submit', '#step1-form', function() {
            $('#preloader').hide();
            var val = $('#sub').val();
            var total = $('#grandTotal').val();

            total = Math.round(total);
            if (val == 0) {
                var handler = PaystackPop.setup({
                    key: '{{ $paystackData['key'] }}',
                    email: $('input[name=email]').val(),
                    amount: total * 100,
                    currency: "{{ $curr->name }}",
                    ref: '' + Math.floor((Math.random() * 1000000000) + 1),
                    callback: function(response) {
                        $('#ref_id').val(response.reference);
                        $('#sub').val('1');
                        $('#final-btn').click();
                    },
                    onClose: function() {
                        window.location.reload();
                    }
                });
                handler.openIframe();
                return false;
            } else {
                $('#preloader').show();
                return true;
            }
        });


        closedFunction = function() {
            alert('window closed');
        }

        successFunction = function(transaction_id) {
            alert('Transaction was successful, Ref: ' + transaction_id)
        }

        failedFunction = function(transaction_id) {
            alert('Transaction was not successful, Ref: ' + transaction_id)
        }
    </script>
