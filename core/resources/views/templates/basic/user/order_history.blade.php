@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-xl-9">
        <div class="row justify-content-end mb-3">
            <div class="col-lg-5">
                <form action="">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control shadow-none outline-0 border--primary" placeholder="@lang('Order ID')"
                            value="{{ $search ?? '' }}">
                        <button type="submit" class="input-group-text bg--primary  text-white border--primary"><i class="las la-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <table class="transection-table-2 box__shadow w-100">
            <thead>
                <tr>
                    <th>@lang('Date')</th>
                    <th>@lang('Order ID')</th>
                    <th>@lang('Product')</th>
                    <th>@lang('Payment')</th>
                    <th>@lang('Status')</th>
                    <th>@lang('Qty')</th>
                    <th>@lang('Amount')</th>
                    <th>@lang('Action')</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="date">
                            {{ showDateTime($order->created_at, 'd M Y') }}
                        </td>

                        <td class="trx-id">{{ $order->order_track }}</td>

                        <td><a target="_blank"
                                href="{{ route('product.details', [$order->product->id, $order->product->slug]) }}">{{ strLimit(@$order->product->name, 20) }}</a>
                        </td>

                        <td>
                            @if ($order->payment_type == Status::PAYMENT_TYPE_DIRECT)
                                @lang('Direct')
                            @else
                                <span title="@lang('Cash On Delivery')">@lang('COD')</span>
                            @endif
                        </td>

                        <td>
                            @php echo $order->statusBadgeStatus @endphp
                        </td>

                        <td class="amount">
                            {{ $order->qty }}
                        </td>

                        <td class="amount">
                            {{ gs('cur_sym') }}{{ getAmount($order->total_amount) }}
                        </td>

                        <td>
                            @if ($order->pay_status != Status::PAYMENT_TYPE_DIRECT && $order->status == Status::ORDER_PENDING)
                                <button class="icon--btn btn--danger confirmationBtn" data-action="{{ route('user.order.cancel',$order->id) }}"
                                    data-question="@lang('Are you sure want to cancel this order?')">
                                    <i class="fa fa-times-circle"></i>
                                </button>
                            @else
                                <button class="icon--btn btn--danger disabled"><i class="fa fa-times-circle"></i></button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">@lang('No order found')</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($orders->hasPages())
            <div class="mt-4">
                {{ paginateLinks($orders) }}
            </div>
        @endif
    </div>
    <x-confirmation-modal />
@endsection

@push('style')
    <style>
        .cancel {
            cursor: pointer;
        }
    </style>
@endpush

@push('script')
    <script>
        'use strict';
        (function($) {
            $('.cancel').on('click', function() {
                var route = $(this).data('route')
                var modal = $('#cancelModal');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.find('form').attr('action', route)
                modal.modal('show');
            })
        })(jQuery);
    </script>
@endpush
