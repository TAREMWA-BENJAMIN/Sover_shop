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
        </div>
    </div>

    <!-- Full Width Products Section -->
    <div class="row mt-4">
        <div class="col-12">
            @if ($featuredProducts->count())
                <section class="products-section">
                    <div class="d-flex justify-content-between align-items-center mb-4 px-4 py-3 w-100 flex-wrap"
                        style="background: linear-gradient(90deg, #f4f6f9, #ffffff); border-radius: 8px; border: 1px solid #eaeef2; border-left: 4px solid #3753ff; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.03);">
                        <h5 class="m-0" style="color: #2c3e50; font-weight: 700; font-size: 20px;">@lang('Welcome to Solver shop Uganda')</h5>
                        <div class="d-none d-lg-flex align-items-center" style="font-size: 15px; color: #4a5568;">
                            <span class="d-flex align-items-center me-3" style="cursor: pointer;"><i
                                    class="las la-file-signature text-primary me-1" style="font-size: 20px;"></i> Feature
                                Products</span>
                            <span class="text-muted mx-2" style="color: #cbd5e0;">|</span>
                            <span class="d-flex align-items-center me-3" style="cursor: pointer;"><i
                                    class="las la-trophy text-warning me-1" style="font-size: 20px;"></i> Top Ranking</span>
                            <span class="text-muted mx-2" style="color: #cbd5e0;">|</span>
                            <a href="#latest-products-section" class="d-flex align-items-center text-decoration-none" style="color: inherit;"><i
                                    class="las la-tools text-success me-1" style="font-size: 20px;"></i> Latest Products</a>
                        </div>
                    </div>
                    <div class="row g-2">
                        @foreach ($featuredProducts as $item)
                            <div class="col-lg-2 col-md-4 col-sm-6 d-flex">
                                <div class="product-item w-100">
                                    <div class="thumb">
                                        <a href="{{ route('product.details', [$item->id, $item->slug]) }}">
                                            <img src="{{ getImage(getFilePath('product') . '/' . $item->image, getFileSize('product')) }}"
                                                alt="products">
                                        </a>
                                        @if (!$item->stock)
                                            <span class="stock-status badge bg--danger">@lang('Stock Out')</span>
                                        @endif
                                    </div>
                                    <div class="content">
                                        <h5 class="product-name">
                                            <a
                                                href="{{ route('product.details', [$item->id, $item->slug]) }}">{{ __($item->name) }}</a>
                                        </h5>
                                        @if ($item->discount > 0)
                                            <div class="d-flex justify-content-between">
                                                <span
                                                    class="price">{{ gs('cur_sym') }}{{ afterDiscount($item->price, $item->discount) }}</span>
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
                <section id="latest-products-section" class="products-section mt-4">
                    <h3 class="section-title">@lang('Latest Products')</h3>
                    <div class="row g-2">
                        @foreach ($latestProducts as $product)
                            <div class="col-lg-2 col-md-4 col-sm-6 d-flex">
                                <div class="product-item w-100">
                                    <div class="thumb">
                                        <a href="{{ route('product.details', [$product->id, $product->slug]) }}">
                                            <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}"
                                                alt="products">
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
                                                <span
                                                    class="price">{{ gs('cur_sym') }}{{ afterDiscount($product->price, $product->discount) }}</span>
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
                <div class="col-lg-4 col-md-8 col-sm-10">
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