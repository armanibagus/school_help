<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0 ps-6" href="{{ url('/') }}">
      <img src="{{ asset('img/logo/mini-logo.png') }}" class="navbar-brand-img h-100" alt="Main logo">
      <span class="ms-1 font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard_super_admin') ? 'active' : ''}}" href="{{ route('dashboard_super_admin') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('super-admin/school') || Request::is('super-admin/school/*') ? 'active' : ''}}" href="{{ route('register_school_admin') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa fa-school text-dark text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">School and Admin</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
