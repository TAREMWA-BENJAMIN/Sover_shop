@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="policy-section pt-50 pb-50">
    <div class="policy-wrapper">
        <h3 class="section-title">{{ __($pageTitle) }}</h3>
        <p>
            @php
                echo $policy->data_values->details;
            @endphp
        </p>
    </div>
</section>
@endsection
