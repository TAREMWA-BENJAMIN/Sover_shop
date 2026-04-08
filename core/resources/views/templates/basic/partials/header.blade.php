@php
    $header = getContent('header.content', true);
@endphp
<!-- Header Section Starts Here -->
<div class="header-top">
    <div class="header-top-area">
        <div class="logo d-none d-md-block"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                    alt="@lang('logo')"></a></div>
        <div class="rolling-headline">
            <marquee scrollamount="4">{{ __(@$header->data_values->notice) }}</marquee>
        </div>
        <div class="header-contacts">
            <p>{{ __(@$header->data_values->heading) }}</p>
            <a href="tel:{{ @$header->data_values->phone }}">{{ @$header->data_values->phone }}</a>
        </div>
    </div>
</div>


<div class="header-bottom">
    <div class="header-bottom-area justify-content-between align-items-center justify-content-lg-between">
        <div class="menu-wrapper w-100">
            <ul class="menu" style="margin: 0; padding: 0; display: flex; align-items: center;">

                <li class="close-trigger d-md-none text-end">
                    <span class="close-menu-trigger">
                        <i class="las la-times"></i>
                    </span>
                </li>

                <!-- New Inline Search Bar (Desktop) -->
                <li class="d-none d-md-block"
                    style="flex: 0 0 auto; width: 450px; max-width: 40%; margin-right: auto; padding-left: 20px;">
                    <form action="{{ route('products') }}" method="GET"
                        style="display: flex; align-items: center; background: #ffffff; border-radius: 6px; padding: 6px 15px; width: 100%; margin: 8px 0;">
                        <input type="text" name="search" placeholder="Type your search here"
                            value="{{ request('search') }}"
                            style="border: none; outline: none; box-shadow: none; width: 100%; color: #333; background: transparent; font-size: 14px;">
                        <button type="submit"
                            style="border: none; background: transparent; padding: 0; outline: none; cursor: pointer; color: #6c7b8f;">
                            <i class="las la-search" style="font-size: 20px;"></i>
                        </button>
                    </form>
                </li>

                <li class="d-none d-xl-block" style="padding: 0 15px;">
                    <span style="color: #ffffff; font-weight: 700; font-size: 14px; letter-spacing: 0.5px;">BUY SMARTER,
                        LIVE BETTER</span>
                </li>

                @guest
                    <li style="display: flex; align-items: center; margin-left: auto; gap: 5px;">
                        <a href="{{ route('user.login') }}"
                            style="color: #ffffff; text-decoration: none; background-color: #00b84d; padding: 8px 16px; border-radius: 4px; font-size: 13px; font-weight: 600;">@lang('Sign in')</a>
                        <span style="color: #ffffff;">|</span>
                        <a href="{{ route('user.register') }}"
                            style="color: #ffffff; text-decoration: none; background-color: #00b84d; padding: 8px 16px; border-radius: 4px; font-size: 13px; font-weight: 600;">@lang('Registration')</a>
                    </li>
                @endguest

            </ul> <!-- Menu End -->

            <div class="header-search-bar d-md-none @if (request()->search) show @endif">
                <form class="search-form pt-md-3 pb-3 pb-md-0" action="{{ route('products') }}" id="searchForm">
                    <input type="text" class="form-control form--control" name="search"
                        placeholder="@lang('Search products by keywords')" value="{{ request('search') }}">
                    <button class="search--button bg--primary" type="submit"><i class="las la-search"></i></button>
                </form>
            </div>
        </div>
        <div class="logo d-md-none me-auto"><a href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                    alt="@lang('logo')"></a></div>

        <div class="header-trigger-wrapper d-flex d-md-none align-items-center me-0">
            <div class="header-trigger d-block d-lg-none">
                <span></span>
            </div>
        </div>
        <div class="search-toggler d-md-none">
            <div class="search-icon text-dark">
                <i class="las la-search"></i>
            </div>
        </div>
    </div>
</div>