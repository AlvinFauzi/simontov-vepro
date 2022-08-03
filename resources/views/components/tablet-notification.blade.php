<div class="dropdown d-none d-md-flex notifications">
    <a class="nav-link icon" data-bs-toggle="dropdown">
        <i class="fe fe-bell"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow ">
        <div class="drop-heading border-bottom">
            <div class="d-flex">
                <h6 class="mt-1 mb-0 fs-16 fw-semibold">{{ trans('lang.myNotification') }}</h6>
                <div class="ms-auto">
                    <span class="badge bg-success rounded-pill">0</span>
                </div>
            </div>
        </div>
        <div class="notifications-menu">

        </div>
        <div class="dropdown-divider m-0"></div>
        {{-- <a href="{{ route('submissionNotification.index') }}" class="dropdown-item text-center p-3 text-muted">
            {{ trans('lang.viewAllNotification') }}
        </a> --}}
    </div>
</div>
