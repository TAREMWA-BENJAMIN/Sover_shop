@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container pt-50 pb-50">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card  custom--card">
                    <div class="card-body">
                        <h2 class="text-center text--danger">@lang('YOU ARE BANNED')</h2>
                        <hr>
                        <p class="fw-bold mb-1 text-center">@lang('Reason'): {{ $user->ban_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
