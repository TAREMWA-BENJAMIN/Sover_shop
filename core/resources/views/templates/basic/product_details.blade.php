@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="product-details-section pb-50 pt-50">
        <div class="row gy-4 gy-sm-5">
            <div class="col-lg-8 col-md-12">
                <div class="product-thumb-wrapper">
                    <div class="sync1 owl-carousel owl-theme">
                        <div class="thumbs zoom ex1">
                            <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}" alt="products-details">
                        </div>
                        @foreach ($product->images as $img)
                            <div class="thumbs zoom ex1">
                                <img src="{{ getImage(getFilePath('product') . '/' . $img->image, getFileSize('product')) }}" alt="products-details">
                            </div>
                        @endforeach
                    </div>
                    <div class="sync2 owl-carousel owl-theme">
                        <div class="thumbs">
                            <img src="{{ getImage(getFilePath('product') . '/' . $product->image, getFileSize('product')) }}" alt="products-details">
                        </div>
                        @foreach ($product->images as $image)
                            <div class="thumbs">
                                <img src="{{ getImage(getFilePath('product') . '/' . $image->image, getFileSize('product')) }}" alt="products-details">
                            </div>
                        @endforeach
                    </div>
                    <h4 class="product-price">@lang('Price') {{ gs('cur_sym') }}{{ getAmount($product->price()) }}</h4>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="product-details">
                    <h3 class="title">{{ __($product->name) }}</h3>
                    <h6 class="mt-1">@lang('Brand'): {{ __($product->brand->name) }}</h6>
                    <h6 class="mt-1">@lang('Category'): {{ __($product->category->name) }}</h6>
                    <h6 class="mt-1">@lang('SKU'): {{ $product->sku }}</h6>
                    <div class="product-desc-wrapper mt-3">
                        <div id="desc-container" style="max-height: 150px; overflow: hidden; position: relative;">
                            @php echo $product->description; @endphp
                        </div>
                        <div id="desc-gradient" style="position: relative; margin-top: -40px; height: 40px; background: linear-gradient(transparent, #ffffff);"></div>
                        <button id="readMoreBtn" onclick="toggleDescription()" class="btn btn-link text--base p-0" style="text-decoration: none; font-weight: 600; display: none; margin-top: 5px;"><span>@lang('Read More')</span> <i class="las la-angle-down"></i></button>
                    </div>

                    <script>
                        function toggleDescription() {
                            var container = document.getElementById("desc-container");
                            var btn = document.getElementById("readMoreBtn");
                            var gradient = document.getElementById("desc-gradient");
                            
                            if (container.style.maxHeight === "150px") {
                                container.style.maxHeight = "none";
                                btn.innerHTML = '<span>@lang("Show Less")</span> <i class="las la-angle-up"></i>';
                                if(gradient) gradient.style.display = "none";
                            } else {
                                container.style.maxHeight = "150px";
                                btn.innerHTML = '<span>@lang("Read More")</span> <i class="las la-angle-down"></i>';
                                if(gradient) gradient.style.display = "block";
                            }
                        }
                        
                        document.addEventListener("DOMContentLoaded", function() {
                            var container = document.getElementById("desc-container");
                            // Add slight buffer to 150px to prevent showing toggle for few pixels
                            if(container.scrollHeight > 160) {
                                document.getElementById("readMoreBtn").style.display = "inline-block";
                            } else {
                                var gradient = document.getElementById("desc-gradient");
                                if(gradient) gradient.style.display = "none";
                            }
                        });
                    </script>

                    <a href="{{ route('checkout', [$product->id, $product->slug]) }}" class="cmn--btn mt-4 bg--base text--white">@lang('Order Now')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="products-section">
        <h3 class="section-title mt-0">@lang('Related Products')</h3>
        <div class="row g-3">
            @foreach ($relatedProducts as $item)
                <div class="col-lg-3 col-xl-3 col-md-4 col-sm-6">
                    <div class="product-item">
                        <div class="thumb">
                            <img src="{{ getImage(getFilePath('product') . '/' . $item->image, getFileSize('product')) }}" alt="products">
                        </div>
                        <div class="content">
                            <h5 class="product-name"><a href="{{ route('product.details', [$item->id, $item->slug]) }}">{{ __($item->name) }}</a></h5>
                            <span class="price">{{ gs('cur_sym') }}{{ getAmount($item->price) }}</span>
                            <div class="button-wrapper">
                                <a href="{{ route('checkout', [$item->id, $item->slug]) }}" class="cmn--btn btn--md bg--primary">@lang('Order Now')</a>
                                <a href="{{ route('product.details', [$item->id, $item->slug]) }}" class="cmn--btn btn--md bg--base">@lang('View Details')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
