@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');

@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
  <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
      @endif

      <!--  Brand demo (display only for navbar-full and hide on below xl) -->
      @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">
            {{-- @include('_partials.macros',["width"=>25,"withbg"=>'#696cff']) --}}
            <img src="{{ asset('assets/img/favicon/jgu.png') }}" alt="">
          </span>
          <span class="app-brand-text demo menu-text fw-bolder">{{config('variables.templateName')}}</span>
        </a>
      </div>
      @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="bx bx-menu bx-sm"></i>
        </a>
      </div>
      @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        @if(request()->is('room_reservation'))
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <form action="/room_reservation" method="GET">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" name="keyword" class="form-control border-0 shadow-none" placeholder="Cari..(mis:lecture theatre)" aria-label="Cari..(mis:lecture theatre)" autofocus>
            </div>
          </form>
        </div>
        <!-- /Search -->
        @endif

        @if(request()->is('building_view'))
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <form action="/building_view" method="GET">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" name="keyword" class="form-control border-0 shadow-none" placeholder="Cari..(mis:gedung merah putih)" aria-label="Cari..(mis:gedung merah putih)" autofocus>
            </div>
          </form>
        </div>
        <!-- /Search -->
        @endif
       
        @if(request()->is('all-ruangan/*'))
              
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <form action="/room_reservation" method="GET">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" name="keyword" class="form-control border-0 shadow-none" placeholder="Cari..(mis:ruang merah putih)" aria-label="Cari..(mis:gedung merah putih)" autofocus>
                @foreach ($rooms as $room)
                <input type="hidden" name="building_id" value="{{ $room->building_id }}">
                @endforeach
              </div>
          </form>
        </div>
        @endif
        
        <!-- /Search -->
        
        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="{{ asset(auth()->user()->avatar) }}" alt class="w-px-40 h-px-40 rounded-circle object-cover">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="{{ asset(auth()->user()->avatar) }}" alt class="w-px-40 h-px-40 rounded-circle object-cover">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-semibold d-block">{{ explode(' ', Auth()->user()->fullname)[0] }}</span>
                      <small class="text-muted">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="/profile/{{ auth()->user()->slug }}">
                  <i class="bx bx-user me-2"></i>
                  <span class="align-middle">Profil Saya</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="/settings">
                  <i class='bx bx-cog me-2'></i>
                  <span class="align-middle">Pengaturan</span>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li>
              <li>
                <a class="dropdown-item" href="/logout">
                  <i class='bx bx-power-off me-2'></i>
                  <span class="align-middle">Log Out</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      @if(!isset($navbarDetached))
    </div>
    @endif
  </nav>
  <!-- / Navbar -->
