@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="row">
        {{-- LEFT: Categories Sidebar --}}
        <div class="col-xl-3 col-lg-3 d-none d-lg-block">
            @include($activeTemplate . 'partials.categories_sidebar')
        </div>

        {{-- RIGHT: Main Content --}}
        <div class="col-xl-9 col-lg-9 col-12">
            @include($activeTemplate . 'partials.banner')
            @if ($featuredProducts->count())
                <section class="products-section">
                    <h3 class="section-title">@lang('Feature Products')</h3>
                    <div class="row g-2">
                        @foreach ($featuredProducts as $item)
                            <div class="col-lg-3 col-sm-6 d-flex">
                                <div class="product-item w-100">
                                    <div class="thumb">
                                        <a href="{{ route('product.details', [$item->id, $item->slug]) }}">
                                            <img src="{{ getImage(getFilePath('product') . '/' . $item->image, getFileSize('product')) }}" alt="products">
                                        </a>
                                        @if (!$item->stock)
                                            <span class="stock-status badge bg--danger">@lang('Stock Out')</span>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <h5 class="product-name">
                                            <a href="{{ route('product.details', [$item->id, $item->slug]) }}">{{ __($item->name) }}</a>
                                        </h5>
                                        @if ($item->discount > 0)
                                            <div class="d-flex justify-content-between">
                                                <span class="price">{{ gs('cur_sym') }}{{ afterDiscount($item->price, $item->discount) }}</span>
                                                <del class="discounted">{{ gs('cur_sym') }}{{ getAmount($item->price) }}</del>
                                            </div>
                                        @else
                                            <span class="price">{{ gs('cur_sym') }}{{ getAmount($item->price) }}</span>
                                        @endif

                                        <div class="button-wrapper">
                                            <a href="{{ route('checkout', [$item->id, $item->slug]) }}"
                                                class="cmn--btn btn--md bg--primary">@lang('Order Now')</a>
                                            <a href="{{ route('product.details', [$item->id, $item->slug]) }}"
                                                class="cmn--btn btn--md bg--base">@lang('View Details')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($latestProducts->count())
                <section class="products-section">
                    <h3 class="section-title">@lang('Latest Products')</h3>
                    <div class="row g-2">
                        @foreach ($latestProducts as $product)
                            <div class="col-lg-3 col-sm-6 d-flex">
                                <div class="product-item w-100">
                                    <div class="thumb">
                                        <a href="{{ route('product.details', [$product->id, $product->slug]) }}">
                                            <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}" alt="products">
                                        </a>
                                        @if (!$product->stock)
                                            <span class="stock-status badge bg--danger">@lang('Stock Out')</span>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <h5 class="product-name">
                                            <a href="{{ route('product.details', [$product->id, $product->slug]) }}">
                                                {{ __($product->name) }}
                                            </a>
                                        </h5>
                                        @if ($product->discount > 0)
                                            <div class="d-flex justify-content-between">
                                                <span class="price">{{ gs('cur_sym') }}{{ afterDiscount($product->price, $product->discount) }}</span>
                                                <del class="discounted">{{ gs('cur_sym') }}{{ getAmount($product->price) }}</del>
                                            </div>
                                        @else
                                            <span class="price">{{ gs('cur_sym') }}{{ getAmount($product->price) }}</span>
                                        @endif
                                        <div class="button-wrapper">
                                            <a href="{{ route('checkout', [$product->id, $product->slug]) }}"
                                                class="cmn--btn btn--md bg--primary">@lang('Order Now')</a>
                                            <a href="{{ route('product.details', [$product->id, $product->slug]) }}"
                                                class="cmn--btn btn--md bg--base">@lang('View Details')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
    @php
        $rows = getContent('overview.element', false, null, true);
    @endphp

    <section class="overview-section pt-50 pb-50">
        <div class="row justify-content-center g-4">
            @foreach ($rows as $row)
                <div class ="col-lg-4 col-md-8 col-sm-10">
                    <div class="overview-item h-100">

                        <div class="thumb">
                            <img src="{{ frontendImage('overview', @$row->data_values->image, '128x128') }}" alt="icon">
                        </div>

                        <div class="content">
                            <h4 class="title">{{ __($row->data_values->heading) }}</h4>
                            <p>{{ __($row->data_values->sub_heading) }}</p>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection
