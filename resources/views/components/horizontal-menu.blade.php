<nav class="horizontalMenu clearfix">
    <ul class="horizontalMenu-list">
        <li aria-haspopup="true">
            <a href="{{ route('home') }}">
                <i class="fe fe-home"></i>
                {{ trans('lang.dashboard') }}
            </a>
        </li>

        <li aria-haspopup="true">
            <a href="{{ route('flowrate.index') }}">
                <i class="fe fe-activity"></i>
                {{ trans('lang.flowrate') }}
            </a>
        </li>
        @role('superAdmin')
            <li aria-haspopup="true">
                <a href="{{ route('alarm.index') }}">
                    <i class="fe fe-bell"></i>
                    Alarm
                </a>
            </li>
        @endrole()

        <li aria-haspopup="true">
            <a href="{{ route('user.index') }}">
                <i class="fe fe-users"></i>
                {{ trans('lang.user') }}
            </a>
        </li>

    </ul>
</nav>
