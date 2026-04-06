@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="row p-0">

        {{-- LEFT SIDEBAR --}}
        <div class="col-lg-3">
            <div class="filter-sidebar">

                {{-- Categories Section --}}
                <div class="filter-sidebar__section">
                    <h5 class="filter-sidebar__heading">@lang('Categories')</h5>
                    <ul class="filter-sidebar__cat-list">
                        <li class="{{ !request('category') ? 'active' : '' }}">
                            <a href="{{ route('products') }}">@lang('All Products')</a>
                            <span>{{ \App\Models\Product::where('status',1)->count() }}</span>
                        </li>
                        @foreach ($categories as $cat)
                            <li class="{{ request('category') == $cat->slug ? 'active' : '' }}">
                                <a href="{{ route('products', ['category' => $cat->slug]) }}">{{ __($cat->name) }}</a>
                                <span>{{ $cat->products_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Price Section --}}
                <div class="filter-sidebar__section">
                    <div class="filter-sidebar__price-header">
                        <h5 class="filter-sidebar__heading mb-0">@lang('Price') <small class="text-muted">({{ gs('cur_sym') }})</small></h5>
                        <span class="filter-sidebar__minus">—</span>
                    </div>

                    <form action="{{ route('products') }}" method="GET" id="priceForm">
                        {{-- Keep existing filters --}}
                        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                        @if(request('brand'))<input type="hidden" name="brand" value="{{ request('brand') }}">@endif
                        @if(request('attribute'))<input type="hidden" name="attribute" value="{{ request('attribute') }}">@endif
                        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif

                        <div class="filter-sidebar__price-inputs">
                            <input type="number" name="min_price" id="minPrice" class="filter-sidebar__price-input"
                                placeholder="min" value="{{ request('min_price') }}" min="0">
                            <span>—</span>
                            <input type="number" name="max_price" id="maxPrice" class="filter-sidebar__price-input"
                                placeholder="max" value="{{ request('max_price') }}" min="0">
                        </div>

                        {{-- Preset Price Ranges --}}
                        @php
                            $rangesFile = storage_path('app/price_ranges.json');
                            $priceRanges = file_exists($rangesFile) ? json_decode(file_get_contents($rangesFile), true) : [];
                        @endphp
                        <ul class="filter-sidebar__price-ranges">
                            @foreach($priceRanges as $range)
                                @php
                                    $isActive = request('min_price') == $range['min'] && request('max_price') == ($range['max'] ?? '');
                                @endphp
                                <li>
                                    <label class="filter-sidebar__radio-label {{ $isActive ? 'active' : '' }}">
                                        <input type="radio" name="_price_preset"
                                            class="price-preset-radio"
                                            data-min="{{ $range['min'] }}"
                                            data-max="{{ $range['max'] ?? '' }}"
                                            {{ $isActive ? 'checked' : '' }}>
                                        {{ $range['label'] }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>

                        <div class="filter-sidebar__price-actions">
                            <a href="{{ route('products', array_filter(request()->except(['min_price','max_price','_price_preset']))) }}"
                               class="filter-sidebar__clear">@lang('CLEAR')</a>
                            <button type="submit" class="filter-sidebar__save">@lang('APPLY')</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-lg-9">
            <div class="main-content">
                <section class="products-section">
                    <h3 class="section-title d-flex justify-content-between">
                        <span>{{ __($pageTitle) }}</span>
                        <span class="sidebar-active d-lg-none">
                            <i class="las la-bars"></i>
                        </span>
                    </h3>

                    <div class="row g-2">
                        @forelse ($products as $product)
                            <div class="col-lg-3 col-sm-6">
                                <div class="product-item">
                                    <div class="thumb">
                                        <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}" alt="products">
                                        @if (!$product->stock)
                                            <span class="stock-status badge bg--danger">@lang('Stock Out')</span>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <h5 class="product-name">
                                            <a href="{{ route('product.details', [$product->id, $product->slug]) }}">{{ __($product->name) }}</a>
                                        </h5>
                                        @if ($product->discount > 0)
                                            <div class="d-flex justify-content-between">
                                                <span class="price">{{ gs('cur_sym') }}{{ getAmount($product->price()) }}</span>
                                                <del class="discounted">{{ gs('cur_sym') }}{{ getAmount($product->price) }}</del>
                                            </div>
                                        @else
                                            <span class="price">{{ gs('cur_sym') }}{{ getAmount($product->price) }}</span>
                                        @endif
                                        <div class="button-wrapper">
                                            <a href="{{ route('checkout', [$product->id, $product->slug]) }}"
                                                class="cmn--btn bg--primary btn--md">@lang('Order Now')</a>
                                            <a href="{{ route('product.details', [$product->id, $product->slug]) }}"
                                                class="cmn--btn bg--base btn--md">@lang('View Details')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center mt-5">
                                <h4>@lang('No products found')</h4>
                            </div>
                        @endforelse
                    </div>
                </section>

                @if ($products->hasPages())
                    <div class="py-4">
                        {{ paginateLinks($products) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('style')
<style>
/* ====== Filter Sidebar ====== */
.filter-sidebar {
    position: sticky;
    top: 20px;
}

.filter-sidebar__section {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    margin-bottom: 16px;
    overflow: hidden;
}

.filter-sidebar__heading {
    font-size: 15px;
    font-weight: 700;
    color: #222;
    padding: 14px 16px;
    border-bottom: 1px solid #eee;
    margin: 0;
}

/* Categories list */
.filter-sidebar__cat-list {
    list-style: none;
    margin: 0;
    padding: 8px 0;
}

.filter-sidebar__cat-list li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 16px;
    transition: background 0.15s;
}

.filter-sidebar__cat-list li:hover,
.filter-sidebar__cat-list li.active {
    background: #f5f5f5;
}

.filter-sidebar__cat-list li.active a {
    font-weight: 700;
    color: #e8041b;
}

.filter-sidebar__cat-list a {
    font-size: 13.5px;
    color: #333;
    text-decoration: none;
    flex: 1;
}

.filter-sidebar__cat-list a:hover { color: #e8041b; }

.filter-sidebar__cat-list span {
    font-size: 12px;
    color: #999;
    margin-left: 6px;
}

/* Price filter */
.filter-sidebar__price-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-bottom: 1px solid #eee;
}

.filter-sidebar__minus { color: #999; font-size: 16px; }

.filter-sidebar__price-inputs {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    border-bottom: 1px solid #f0f0f0;
}

.filter-sidebar__price-input {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 7px 10px;
    font-size: 13px;
    color: #333;
    outline: none;
    width: 100%;
}

.filter-sidebar__price-input:focus {
    border-color: #28a745;
}

/* Preset ranges */
.filter-sidebar__price-ranges {
    list-style: none;
    margin: 0;
    padding: 6px 0;
    border-bottom: 1px solid #f0f0f0;
}

.filter-sidebar__price-ranges li {
    padding: 4px 16px;
}

.filter-sidebar__radio-label {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #444;
    cursor: pointer;
    white-space: nowrap;
    width: 100%;
}

.filter-sidebar__radio-label input[type="radio"] {
    flex-shrink: 0;
    width: 16px;
    height: 16px;
    accent-color: #28a745;
    cursor: pointer;
}

.filter-sidebar__radio-label span {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.filter-sidebar__radio-label.active {
    color: #28a745;
    font-weight: 600;
}

/* Actions */
.filter-sidebar__price-actions {
    display: flex;
    justify-content: space-between;
    padding: 10px 16px;
}

.filter-sidebar__clear {
    font-size: 12px;
    font-weight: 600;
    color: #999;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-sidebar__clear:hover { color: #555; }

.filter-sidebar__save {
    font-size: 12px;
    font-weight: 700;
    color: #28a745;
    background: none;
    border: none;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0;
}

.filter-sidebar__save:hover { color: #1a7a31; }
</style>
@endpush

@push('script')
<script>
'use strict';
(function($) {
    // Preset radio → fill min/max
    $('.price-preset-radio').on('change', function() {
        $('#minPrice').val($(this).data('min'));
        $('#maxPrice').val($(this).data('max'));
        $('.filter-sidebar__radio-label').removeClass('active');
        $(this).closest('label').addClass('active');
    });

    // Manual input → uncheck preset
    $('#minPrice, #maxPrice').on('input', function() {
        $('.price-preset-radio').prop('checked', false);
        $('.filter-sidebar__radio-label').removeClass('active');
    });
})(jQuery);
</script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush
