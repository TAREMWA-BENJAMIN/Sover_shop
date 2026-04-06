@extends($activeTemplate . 'layouts.frontend')
@php
    $contact = getContent('contact_us.content', true);
@endphp
@section('content')
    <section class="contact-section pt-50 pb-50">
        <div class="row gy-4">
            <div class="col-lg-7">
                <div class="contact-form-wrapper">
                    <h4 class="title">{{ __(@$contact->data_values->heading) }}</h4>
                    <form class="contact-form verify-gcaptcha" method="post" action="">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-6 ">
                                <input name="name" type="text" class="form-control form--control" placeholder="@lang('name')"
                                    value="{{ old('name', @$user->fullname) }}" @if ($user && $user->profile_complete) readonly @endif required>
                            </div>
                            <div class="form-group col-lg-6">
                                <input name="email" type="email" class="form-control form--control" placeholder="@lang('email')"
                                    value="{{ old('email', @$user->email) }}" @if ($user) readonly @endif required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Subject')</label>
                            <input name="subject" type="text" class="form-control form--control" placeholder="@lang('Write your Subject')"
                                value="{{ old('subject') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Message')</label>
                            <textarea name="message" class="form-control form--control" placeholder="@lang('Write your massage')" required>{{ old('message') }}</textarea>
                        </div>
                        <x-captcha />
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="contact-info-wrapper">
                    <h4 class="title">@lang('Hotline'):</h4>
                    <ul class="contact-list">
                        <li>
                            <a href="tel:{{ $contact->data_values->phone }}"><i class="las la-phone-volume"></i>
                                {{ __($contact->data_values->phone) }}
                            </a>
                        </li>
                    </ul>
                    <h4 class="title">@lang('Email'):</h4>
                    <ul class="contact-list">
                        <li>
                            <a href="mailto:{{ $contact->data_values->email }}"><i class="las la-envelope"></i>
                                {{ __($contact->data_values->email) }}
                            </a>
                        </li>
                    </ul>
                    <h4 class="title">@lang('Address')</h4>
                    <p class="address">
                        <i class="las la-map"></i> {{ __(@$contact->data_values->address) }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section Starts Here -->
    <div class="gmaps-area">
        <iframe
            src = "https://maps.google.com/maps?q={{ @$contact->data_values->map_latitude }},{{ @$contact->data_values->map_longitude }}&hl=es;z=14&amp;output=embed"></iframe>
    </div>
@endsection
