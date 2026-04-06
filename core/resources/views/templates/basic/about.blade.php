@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="about-section pt-50 pb-50">
    <div class="about-content">
        <h3 class="section-title mt-0">{{ __($pageTitle) }}</h3>
        <p>
            @php
                echo @$content->data_values->details;
            @endphp
        </p>
    </div>
</section>

@endsection
