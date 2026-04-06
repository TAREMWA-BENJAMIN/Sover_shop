@extends($activeTemplate.'layouts.frontend')
@section('content')
<!-- Faq Section Starts Here -->
<section class="faq-section pt-50 pb-50">
    <h3 class="section-title">{{ __(@$content->data_values->heading) }}</h3>
    <div class="row gx-5 gy-4"">
        @foreach($faqs as $faq)
            <div class="col-lg-6">
                <div class="faq-item">
                    <h4 class="faq-title">{{ __($faq->data_values->question) }}</h4>
                    <div class="faq-content">
                        <p>{{ __($faq->data_values->answer) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
