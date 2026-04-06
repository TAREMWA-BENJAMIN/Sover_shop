<div class="col-xl-3">
    <div class="dashboard-sidebar">
        <div class="close-dashboard d-xl-none">
            <i class="las la-times"></i>
        </div>
        <div class="dashboard-user">
            <div class="user-thumb">
                <img src="{{ getImage(getFilePath('userProfile') . '/' .auth()->user()->image, getFileSize('userProfile'),avater:true) }}" alt="dashboard">
            </div>
            <div class="user-content">
                <h5 class="name">{{auth()->user()->fullname}}</h5>
            </div>
        </div>
        <ul class="user-dashboard-tab">
            <li>
                <a href="{{route('user.home')}}" class="{{menuActive('user.home')}}"><i class="las la-home"></i> @lang('Dashboard')</a>
            </li>
            <li>
                <a href="{{route('user.order.history')}}" class="{{menuActive('user.order.history')}}"><i class="las la-history"></i> @lang('Order History')</a>
            </li>
            <li>
                <a href="{{route('user.deposit.history')}}" class="{{menuActive('user.deposit.history')}}"><i class="las la-wallet"></i> @lang('Payment History')</a>
            </li>

            <li>
                <a href="{{route('user.profile.setting')}}" class="{{menuActive('user.profile.setting')}}"><i class="las la-users-cog"></i> @lang('Profile Setting')</a>
            </li>
            <li>
                <a href="{{route('user.change.password')}}" class="{{menuActive('user.change.password')}}"><i class="las la-key"></i> @lang('Change Password')</a>
            </li>
            <li>
                <a href="{{route('user.logout')}}" class="{{menuActive('user.logout')}}"><i class="las la-sign-out-alt"></i> @lang('Log out')</a>
            </li>
        </ul>
    </div>
</div>
