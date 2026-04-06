<div class="banner-slider owl-theme owl-carousel">
    @foreach ($banners as $banner)
        <div class="owl-item">
            <div class="banner-section bg_img"
                style="background: url({{ frontendImage('banner', @$banner->data_values->image, '1920x1280') }}) center;">
                <div class="banner-content">
                    <span class="subtitle">{{ __(@$banner->data_values->heading) }}</span>
                    <h1 class="title">{{ __(@$banner->data_values->text) }}</h1>
                    <a href="{{ url(@$banner->data_values->button_url) }}" class="cmn--btn">{{ __(@$banner->data_values->button_text) }}</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
