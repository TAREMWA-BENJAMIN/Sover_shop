<div class="banner-wrapper" style="height: 100%;">
    <div class="banner-slider owl-theme owl-carousel h-100">
        @foreach ($banners as $banner)
            <div class="owl-item h-100">
                <div class="banner-section bg_img w-100 h-100"
                    style="background: url({{ frontendImage('banner', @$banner->data_values->image, '1920x1280') }}) center; background-size: cover;">
                    <div class="banner-content">
                        <span class="subtitle">{{ __(@$banner->data_values->heading) }}</span>
                        <h1 class="title">{{ __(@$banner->data_values->text) }}</h1>
                        <a href="{{ url(@$banner->data_values->button_url) }}" class="cmn--btn">{{ __(@$banner->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    /* Ensure the column wrapping the banner has flex height */
    .banner-section {
        display: flex;
        align-items: center;
        padding-left: 50px; /* Preserve inner spacing if any */
        border-radius: 8px;
        min-height: 100%;
        width: 100%;
    }
    .banner-wrapper, .banner-slider, .banner-slider .owl-stage-outer, .banner-slider .owl-stage, .banner-slider .owl-item {
        height: 100% !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function matchBannerHeight() {
            const sidebar = document.querySelector('.cat-sidebar');
            const wrapper = document.querySelector('.banner-wrapper');
            if(sidebar && wrapper) {
                // We lock the banner to exactly match the height of the sidebar element
                wrapper.style.height = sidebar.getBoundingClientRect().height + 'px';
            }
        }
        
        // Match height immediately and after slight delay for fonts/images loading
        setTimeout(matchBannerHeight, 100);
        setTimeout(matchBannerHeight, 600);
        
        // Match height on resize
        window.addEventListener('resize', matchBannerHeight);
    });
</script>
