@extends($activeTemplate . 'layouts.frontend')
@php  $user = auth()->user() @endphp
@section('content')
    <section class="checkout-section pt-50 pb-50">
        <form action="{{ route('user.order.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="row checkout-wrapper gy-4">
                <div class="col-lg-7">
                    <div class="checkout-form-wrapper">
                        <h3 class="title">@lang('Shipping Details')</h3>
                        <div class="row checkout-form gy-4">
                            <div class="col-md-12">
                                <div class="form--group">
                                    <label for="fname" class="form-label">@lang('Name') </label>
                                    <input id="fname" name="name" type="text" class="form--control" placeholder="@lang('First Name')"
                                        value="{{ $user ? $user->fullname : old('fname') }}" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form--group">
                                    <label for="country" class="form-label">@lang('City')</label>
                                    <input id="country" name="city" type="text" class="form--control" placeholder="@lang('City')"
                                        value="{{ $user ? @$user->city : old('city') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form--group">
                                    <label for="street" class="form-label">@lang('Address') </label>
                                    <input id="street" name="address" type="text" class="form--control" placeholder="@lang('Street Address')"
                                        value="{{ $user ? @$user->address : old('address') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form--group">
                                    <label for="post-code" class="form-label">@lang('Post Code / Zip')</label>
                                    <input id="post-code" name="post_code" type="tel" class="form--control" placeholder="@lang('Post Code / Zip')"
                                        value="{{ $user ? @$user->zip : old('post_code') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form--group">
                                    <label for="email" class="form-label">@lang('Email Address')</label>
                                    <input id="email" name="email" type="email" class="form--control" placeholder="@lang('Email Address')"
                                        value="{{ $user ? $user->email : old('email') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form--group">
                                    <label for="tel" class="form-label">@lang('Phone Number')</label>
                                    <input id="tel" name="phone" type="tel" class="form--control" placeholder="@lang('Phone Number')"
                                        value="{{ $user ? $user->mobile : old('phone') }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="note">@lang('Additional Info for Shipping') <span>@lang('(Optional)')</span></label>
                                <textarea class="form--control" name="additional" placeholder="@lang('Additional Info for Shipping')">{{ old('additional') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="order-area">
                        <h3 class="title">@lang('Your Order')</h3>
                        <div class="check-list-wrapper">
                            <ul class="check-list">
                                <li class="check-list-item">
                                    <div class="check-img">
                                        <a href="{{ route('product.details', [$product->id, $product->slug]) }}">
                                            <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}"
                                                alt="products">
                                        </a>
                                    </div>
                                    <div class="check-content">
                                        <a class="text--primary"
                                            href="{{ route('product.details', [$product->id, $product->slug]) }}">{{ __($product->name) }}</a>
                                        <p class="check-price">{{ showAmount($product->price()) }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="title">@lang('Your Order Details')</h3>
                        <ul class="order-history">
                            <li class="order-details"></li>
                            <li class="order-details">
                                <span class="title">@lang('In Stock')</span>
                                <span class="subtitle fw-bold">{{ $product->stock == 0 ? 'Stock Out' : $product->stock }}</span>
                            </li>
                            <li class="order-details">
                                <span class="title">@lang('Quantity')</span>
                                <span class="subtitle d-flex justify-content-end">
                                    <div class="input-group">
                                        <span class="input-group-text bg--primary border--primary text-white  qtybutton dec" onclick="qty('dec')"
                                            id="my-addon"><i class="las la-minus"></i></span>
                                        <input class="cart-count form-control text-center shadow-none outline-0  border-0" name="qty"
                                            type="text" value="1" readonly>
                                        <span class="input-group-text bg--primary border--primary text-white  qtybutton inc" onclick="qty('inc')"
                                            id="my-addon"><i class="las la-plus"></i></span>
                                    </div>
                                </span>
                            </li>
                            <li class="order-details">
                                <span class="title">
                                    <div class="form--group custom--radio mb-2">
                                        <input id="inside-city" type="radio" name="shipping"
                                            data-charge="{{ getAmount(gs('shipping_charge_inside')) }}" value="1" checked>
                                        <label for="inside-city">@lang('Shipping Charge Inside ' . gs('city'))</label>
                                    </div>
                                </span>
                                <span class="subtitle fw-bold">
                                    @if (gs('shipping_charge_inside') == -1)
                                        @lang('FREE')
                                    @else
                                        <b class="inside">{{ getAmount(gs('shipping_charge_inside')) }}</b>
                                    @endif
                                </span>
                            </li>
                            <li class="order-details">
                                <span class="title">
                                    <div class="form--group custom--radio mb-2">
                                        <input id="outside-city" type="radio" data-charge="{{ getAmount(gs('shipping_charge_outside')) }}"
                                            name="shipping" value="2">
                                        <label for="outside-city">@lang('Shipping Charge Outside ' . gs('city'))</label>
                                    </div>
                                </span>
                                <span class="subtitle fw-bold">
                                    @if (gs('shipping_charge_outside') == -1)
                                        @lang('FREE')
                                    @else
                                        {{ gs('cur_sym') }}<b class="outside">{{ getAmount(gs('shipping_charge_outside')) }}</b>
                                    @endif
                                </span>
                            </li>
                            <li class="order-details">
                                <span class="title">@lang('Total'):</span>
                                <span class="subtitle total fw-bold">{{ gs('cur_sym') }}<b
                                        class="in_total">{{ gs('shipping_charge_inside') == -1 ? getAmount($product->price()) : getAmount($product->price() + gs('shipping_charge_inside')) }}</b>
                                </span>
                            </li>
                        </ul>
                        <h3 class="title">@lang('Payment Method')</h3>
                        <div class="order-form">
                            <div class="form--group custom--radio mb-2">
                                <input id="check-payment" type="radio" name="payment" value="1" checked>
                                <label for="check-payment">@lang('Direct Payment') <code>(@lang('Additional charges may apply'))</code></label>
                            </div>
                            <div class="form--group custom--radio mb-2">
                                <input id="cod" type="radio" name="payment" value="2">
                                <label for="cod">@lang('Cash On Delivery')</label>
                            </div>
                            @if ($product->stock != 0)
                                <button class = "mt-3 w-100 checkout-button" type = "submit">@lang('Confirm Your Order')</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('script')
    <script>
        'use strict';

        (function($) {
            $('input[name=shipping]').on('click', function() {
                var inside = parseFloat($('.inside').text())
                var outside = parseFloat($('.outside').text())
                var productPrice = '{{ getAmount($product->price()) }}'
                var qty = parseFloat($('.cart-count').val())
                var total;

                if (inside == -1) {
                    inside = 0;
                }
                if (outside == -1) {
                    outside = 0;
                }
                if ($(this).val() == 1) {
                    total = parseFloat(productPrice * qty) + inside;
                } else if ($(this).val() == 2) {
                    total = parseFloat(productPrice * qty) + outside;
                } else {
                    total = 0.00;
                }
                $('.in_total').text(total.toFixed(2));
            });

        })(jQuery);

        function qty(type) {
            var productPrice = parseFloat('{{ getAmount($product->price()) }}')
            var stock = parseFloat('{{ getAmount($product->stock) }}')
            var inTotal = parseFloat($('.in_total').text())
            var qty = parseFloat($('.cart-count').val())
            var charge = parseFloat($('input[name=shipping]:checked').data('charge'))
            var updateTotal;


            if (qty > stock) {
                notify('error', 'Quantity exceeds the remaining stock.')
                return false
            }

            if (type == 'inc') {
                updateTotal = inTotal + productPrice
            } else if (type == 'dec') {
                updateTotal = inTotal - productPrice
            } else {
                return false
            }
            if (updateTotal < (charge + productPrice)) {
                var value;
                if (qty > 1) {
                    value = charge + (productPrice * qty)
                } else {
                    value = charge + productPrice
                }
                $('.in_total').text(value)
                return false
            }
            $('.in_total').text(updateTotal.toFixed(2))
        }
    </script>
@endpush

@push('style')
    <style>
        .input-group {
            width: 53% !important;
        }

        .input-group-text {
            cursor: pointer;
        }
    </style>
@endpush
