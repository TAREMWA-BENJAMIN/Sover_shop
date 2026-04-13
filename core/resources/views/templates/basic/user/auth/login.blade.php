@extends($activeTemplate . 'layouts.auth_master')
@php
    $bgImage = getContent('auth.content', true);
@endphp

@section('content')
    <section class="account-section bg_img d-flex" style="background: url({{ frontendImage('auth', @$bgImage->data_values->image, '1920x1280') }}) right;">
        <div class="account-wrapper">
            <div class="logo mb-4">
                <a href="{{ route('home') }}">
                    <img src="{{ siteLogo() }}" alt="@lang('logo')">
                </a>
            </div>
            <h3 class="title mb-5">@lang('Login to your Account')</h3>
            @include($activeTemplate . 'partials.social_login')
            <form action="{{ route('user.login') }}" method="post" class="account-form mt-2">
                @csrf
                <div class="form--group">
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="@lang('Username or Email')" class="form--control" required>
                </div>
                <div class="form--group">
                    <input id="password" type="password" placeholder="@lang('Password')" class="form--control" name="password" required>
                </div>
                <div class="form-group form-check mt-2">
                    <div class="d-flex align-items-center gap-2 justify-content-between">
                        <div>
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label mb-0" for="remember">
                                @lang('Remember Me')
                            </label>
                        </div>
                        <div>
                            <a class="text--base m-0" href="{{ route('user.password.request') }}">@lang('Forgot Password')?</a>
                        </div>
                    </div>
                </div>
                <div class="form--group">
                    <button type="submit" class="login">@lang('Sign in')</button>
                </div>
            </form>
            <h6>
                @lang('Already have an account')?
                <a class="text--base" href="{{ route('user.register') }}">@lang('Sign Up')</a>
            </h6>
        </div>
    </section>
@endsection
