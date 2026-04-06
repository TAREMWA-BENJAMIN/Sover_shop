@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-xl-9">
        <div class="row dashboard-card-wrapper pb-50 g-3">
            <div class="col-sm-6 col-lg-6 col-xl-4">
                <div class="dashboard-card-item">
                    <div class="icon">
                        <i class="las la-money-bill"></i>
                    </div>
                    <div class="content">
                        <h6 class="title">@lang('Total Paid Order')</h6>
                        <p class="price">{{ $paidOrder }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-4">
                <div class="dashboard-card-item">
                    <div class="icon">
                        <i class="las la-ruble-sign"></i>
                    </div>
                    <div class="content">
                        <h6 class="title">@lang('Total Unpaid Order')</h6>
                        <p class="price">{{ $unPaidOrder }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-4">
                <div class="dashboard-card-item">
                    <div class="icon">
                        <i class="las la-spinner"></i>
                    </div>
                    <div class="content">
                        <h6 class="title">@lang('Pending Order')</h6>
                        <p class="price">{{ $pendingOrder }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-4">
                <div class="dashboard-card-item">
                    <div class="icon">
                        <i class="las la-truck"></i>
                    </div>
                    <div class="content">
                        <h6 class="title">@lang('Total Delivered')</h6>
                        <p class="price">{{ $deliveredOrder }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-4">
                <div class="dashboard-card-item">
                    <div class="icon">
                        <i class="las la-sync"></i>
                    </div>
                    <div class="content">
                        <h6 class="title">@lang('Order Processing')</h6>
                        <p class="price">{{ $processOrder }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 col-xl-4">
                <div class="dashboard-card-item">
                    <div class="icon">
                        <i class="las la-money-bill-wave"></i>
                    </div>
                    <div class="content">
                        <h6 class="title">@lang('Total Purchased')</h6>
                        <p class="price">{{ showAmount($totalPurchase) }}</p>
                    </div>
                </div>
            </div>

        </div>
        <h4 class="title mb-4">@lang('Latest Orders')</h4>

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
                </tr>
            </thead>
            <tbody>
                @forelse ($latestOrders as $order)
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
                            @if (!$order->status)
                                <span class="badge bg--warning badge--md">@lang('Pending')</span>
                            @elseif($order->status == Status::ORDER_COMPLETED)
                                <span class="badge bg--success badge--md">@lang('Delivered')</span>
                            @elseif($order->status == Status::ORDER_PROCESSING)
                                <span class="badge bg--info badge--md">@lang('Processing')</span>
                            @elseif($order->status == Status::ORDER_CANCELLED)
                                <span class="badge bg--danger badge--md">@lang('Cancelled')</span>
                            @endif
                        </td>

                        <td class="amount">
                            {{ $order->qty }}
                        </td>

                        <td class="amount">
                            {{ gs('cur_sym') }}{{ getAmount($order->total_amount) }}
                        </td>

                    
                    </tr>
                @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">@lang('No order found')</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body text-center">
                        <i class="las la-exclamation-circle text-danger display-2 mb-15"></i>
                        <h4 class="text--dark mb-15">@lang('Are you sure want to cancel this order?')</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn--dark h-auto" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn--danger  h-auto del">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

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
