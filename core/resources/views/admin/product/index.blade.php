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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Category | Brand')</th>
                                    <th>@lang('Price | Discount')</th>
                                    <th>@lang('Final Price')</th>
                                    <th>@lang('Stock | SKU')</th>
                                    <th>@lang('Sold')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Is Featured')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ strLimit($product->name, 30) }}</td>
                                        <td>
                                            <div>
                                                {{ __($product->category->name) }} <br /> {{ __($product->brand->name) }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ showAmount($product->price) }}
                                            <div class="font-weight-bold">
                                                {{ getAmount($product->discount) }}@lang('%')
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $discount = $product->hot_deal == 1 ? gs('hot_deal_discount') : $product->discount;
                                            @endphp
                                            <span>{{ gs('cur_sym') }}{{ afterDiscount($product->price, $discount) }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                @if ($product->stock)
                                                    <span>{{ $product->stock }}</span>
                                                @else
                                                    <span class="text--warning">@lang('Stock Out')</span>
                                                @endif
                                                <br />
                                                {{ $product->sku }}
                                            </div>
                                        </td>
                                        <td>{{ $product->sold }} @lang('PCS')</td>
                                        <td>@php echo $product->statusBadge @endphp</td>
                                        <td>@php echo $product->featuredBadge @endphp</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn btn-outline--primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    @lang('Action')
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <a href="{{ route('admin.product.update.page', $product->id) }}"
                                                        class=" dropdown-item text--primary">
                                                        <i class="la la-pencil-alt"></i> @lang('Edit')
                                                    </a>
                                                    <a href="{{ route('admin.product.image.page', $product->id) }}" class=" dropdown-item text--dark">
                                                        <i class="las la-image"></i> @lang('Images')
                                                    </a>
                                                    @if ($product->hot_deal == 0)
                                                        <button data-action="{{ route('admin.product.hot.deal', $product->id) }}"
                                                            class=" dropdown-item text--info confirmationBtn" data-question="@lang('Are you sure to add this product to the hot deal?')">
                                                            <i class="las la-fire-alt"></i> @lang('Add as hot deal')
                                                        </button>
                                                    @else
                                                        <button data-action="{{ route('admin.product.hot.deal', $product->id) }}"
                                                            class=" dropdown-item text--warning confirmationBtn" data-question="@lang('Are you sure to remove this product from the hot deal?')">
                                                            <i class="las la-fire-alt"></i> @lang('Remove from hot deals')
                                                        </button>
                                                    @endif
                                                    @if ($product->status == Status::DISABLE)
                                                        <button type="button" class=" dropdown-item text--success ms-1 confirmationBtn"
                                                            data-action="{{ route('admin.product.status', $product->id) }}"
                                                            data-question="@lang('Are you sure to enable this product?')">
                                                            <i class="la la-eye"></i> @lang('Enable')
                                                        </button>
                                                    @else
                                                        <button type="button" class=" dropdown-item text--danger confirmationBtn"
                                                            data-action="{{ route('admin.product.status', $product->id) }}"
                                                            data-question="@lang('Are you sure to disable this product?')">
                                                            <i class="la la-eye-slash"></i> @lang('Disable')
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
                @if ($products->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($products) @endphp
                    </div>
                @endif
            </div>
        </div>

    </div>

    <x-confirmation-modal />
@endsection



@push('breadcrumb-plugins')
    <x-search-form placeholder="Name / SKU" />

    <a href="{{ route('admin.product.add.page') }}" class=" btn btn-sm btn-outline--primary">
        <i class="la la-fw la-plus"></i>@lang('Add New')
    </a>
@endpush
