@extends($activeTemplate.'layouts.frontend')
@section('content')

<section class="policy-section pt-50 pb-50" style="background-color: #f7f9f9;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10">
                <div class="policy-card shadow-sm bg-white" style="border-radius: 12px; overflow: hidden; border: 1px solid #eee;">
                    
                    {{-- Premium Top Banner (Uniform Red theme) --}}
                    <div class="policy-banner" style="background: linear-gradient(135deg, #db1e36, #a81528); padding: 45px 30px; text-align: center;">
                        <h2 class="text-white m-0" style="font-weight: 700; letter-spacing: 1px; font-size: 32px;">{{ __($pageTitle) }}</h2>
                        <div style="width: 50px; height: 3px; background: #ffffff; margin: 20px auto 0; border-radius: 3px;"></div>
                    </div>

                    {{-- Dynamic Content Wrapper --}}
                    <div class="policy-dynamic-content p-4 p-md-5">
                        @php
                            echo $policy->data_values->details;
                        @endphp
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@push('style')
<style>
    /* Styling the dynamic content block */
    .policy-dynamic-content {
        color: #555;
        font-size: 15px;
        line-height: 1.8;
    }
    
    .policy-dynamic-content p {
        margin-bottom: 24px;
        font-family: inherit;
    }
    
    .policy-dynamic-content h1, 
    .policy-dynamic-content h2, 
    .policy-dynamic-content h3, 
    .policy-dynamic-content h4 {
        color: #222;
        font-weight: 700;
        margin-top: 40px;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }
    
    .policy-dynamic-content h1::after,
    .policy-dynamic-content h2::after,
    .policy-dynamic-content h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 3px;
        background: #db1e36;
        border-radius: 3px;
    }

    .policy-dynamic-content ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 35px;
        margin-top: 20px;
    }
    
    .policy-dynamic-content ul li {
        position: relative;
        margin-bottom: 15px;
        background: #fafafa;
        padding: 14px 20px 14px 45px;
        border-radius: 6px;
        border-left: 3px solid #888;
        transition: all 0.3s ease;
        color: #444;
    }
    
    .policy-dynamic-content ul li:hover {
        background: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-left-color: #db1e36;
    }

    .policy-dynamic-content ul li::before {
        content: '✔';
        position: absolute;
        left: 17px;
        top: 14px;
        color: #db1e36;
        font-size: 14px;
    }

    .policy-dynamic-content strong, 
    .policy-dynamic-content b {
        color: #111;
        font-weight: 600;
    }
</style>
@endpush
@endsection
