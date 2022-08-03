<a class="nav-link icon text-uppercase" id="activeLanguage" data-bs-toggle="dropdown"
    data-lang="{{ session()->get('locale') ?? 'ID' }}">
    @if (session()->get('locale') === 'en')
        <i class="flag flag-gb"></i>
    @else
        <i class="flag flag-id"></i>
    @endif
</a>
<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow ">
    <a href="{{ route('setLocale', ['id']) }}" class="dropdown-item text-center text-muted"><i
            class="flag flag-id"></i> {{ __('lang.id') }}</a>
    <a href="{{ route('setLocale', ['en']) }}" class="dropdown-item text-center text-muted"><i
            class="flag flag-gb"></i> {{ __('lang.en') }}</a>
</div>
