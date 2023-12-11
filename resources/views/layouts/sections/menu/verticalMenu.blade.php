<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        {{-- @include('_partials.macros',["width"=>25,"withbg"=>'#696cff']) --}}
        <img src="{{ asset('assets/img/favicon/upr.png') }}" alt="" class="app-brand-logo demo" width="45px">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
    </a>

    {{-- <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/img/favicon/upr_back.png') }}" alt="" width="70px">
      </span>
      <span class="fs-4 demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
    </a> --}}

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">

    @php
$currentRole = auth()->user()->role; // Mendapatkan peran pengguna yang terautentikasi
@endphp

@foreach ($menuData[0]->menu as $menu)
  @if (isset($menu->menuHeader))
    @if (!isset($menu->roles) || in_array($currentRole, $menu->roles))
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">{{ $menu->menuHeader }}</span>
      </li>
    @endif
  @else
    @if (!isset($menu->roles) || in_array($currentRole, $menu->roles))
      @php
      $activeClass = null;
      $currentRouteName = Route::currentRouteName();

      if (in_array($currentRouteName, $menu->slug)) {
        $activeClass = 'active';
      }
      elseif (isset($menu->submenu)) {
        if (gettype($menu->slug) === 'array') {
          foreach($menu->slug as $slug){
            if (str_contains($currentRouteName,$slug) && strpos($currentRouteName,$slug) === 0) {
              $activeClass = 'active open';
            }
          }
        }
        else {
          if (str_contains($currentRouteName,$menu->slug) && strpos($currentRouteName,$menu->slug) === 0) {
            $activeClass = 'active open';
          }
        }
      }
      @endphp

      <li class="menu-item {{ $activeClass }}">
        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
          @isset($menu->icon)
          <i class="{{ $menu->icon }}"></i>
          @endisset
          <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
        </a>

        @isset($menu->submenu)
          @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
        @endisset
      </li>
    @endif
  @endif
@endforeach
  </ul>

</aside>
