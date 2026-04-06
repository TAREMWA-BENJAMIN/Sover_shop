@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Order ID') | @lang('User')</th>
                                    <th>@lang('Product')</th>
                                    <th>@lang('Qty')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Payment')</th>
                                    <th>@lang('Order Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <td>
                                        <div>
                                            {{ showDateTime($order->created_at, 'd M, Y') }}
                                        </div>

                                        {{ showDateTime($order->created_at, 'h:i A') }}
                                    </td>

                                    <td>
                                        <div>{{ $order->order_track }}</div>
                                        <a target="_blank" href="{{ route('admin.users.detail', $order->user_id) }}">{{ @$order->user->username }}</a>
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ route('product.details', [$order->product->id, $order->product->slug]) }}">
                                            {{ strLimit(@$order->product->name, 20) }}({{ $order->product->sku }})</a>
                                    </td>

                                    <td>
                                        <span class="badge badge--primary font-weight-bold">{{ $order->qty }}</span>
                                    </td>

                                    <td>
                                        {{ showAmount($order->total_amount) }}
                                    </td>

                                    <td>
                                        @if ($order->payment_type == Status::PAYMENT_TYPE_DIRECT)
                                            <span title="@lang('Direct Payment')">@lang('DP')</span>
                                        @else
                                            <span title="@lang('Cash On Delivery')">@lang('COD')</span>
                                        @endif
                                    </td>

                                    <td>
                                        @php echo $order->statusBadge @endphp
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn btn-outline--primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                @lang('Action')
                                            </button>
                                            <ul class="dropdown-menu">

                                                <a href="{{ route('admin.order.details', $order->id) }}" class="dropdown-item text--primary">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>

                                                @if ($order->status == Status::ORDER_PENDING)
                                                    <button data-action="{{ route('admin.order.process', $order->id) }}"
                                                        class=" dropdown-item text--info confirmationBtn" data-question="@lang('Are you sure to mark this order as processing?')">
                                                        <i class="las la-spinner"></i>
                                                        @lang('Mark as Processing')
                                                    </button>
                                                @elseif($order->status == Status::ORDER_PROCESSING)
                                                    <button data-action="{{ route('admin.order.deliver', $order->id) }}"
                                                        class=" dropdown-item text--success confirmationBtn" data-question="@lang('Are you sure this order has been delivered?')">
                                                        <i class="lar la-check-circle"></i>
                                                        @lang('Mark as Delivered')
                                                    </button>
                                                @endif
                                                @if ($order->status == Status::ORDER_PENDING && $order->pay_status == Status::PAY_PENDING)
                                                    <button type="button" class=" dropdown-item text--danger confirmationBtn"
                                                        data-action="{{ route('admin.order.cancel') }}" data-question="@lang('Are you sure to cancel this order?')"><i
                                                            class="las la-ban"></i>
                                                        @lang('Cancel Order')
                                                    </button>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($orders->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($orders) @endphp
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection



@push('breadcrumb-plugins')
    <x-search-form placeholder="Order ID" />
@endpush
