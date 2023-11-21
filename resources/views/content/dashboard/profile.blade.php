@extends('layouts/contentNavbarLayout')

@section('title', $user->fullname)

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}">
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
@endsection

@section('vendor-script')
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endsection

@section('page-script')
<script>
    $(document).ready(function() {
        var toast = $('#toast');
        toast.toast('show'); // Menampilkan toast

        // Menutup toast secara otomatis setelah 5 detik (5000 ms)
        setTimeout(function() {
        toast.toast('hide');
        }, 2500);
    });

</script>
@endsection

@section('content')

@if (session()->has('message'))
<div id="toast" class="bs-toast toast toast-placement-ex m-2 fade bg-success top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <i class="bx bx-bell me-2"></i>
      <div class="me-auto fw-semibold">Berhasil!</div>
      <small>Baru saja</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{ session('message') }}
    </div>
</div>
@endif

<!-- Header -->
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="user-profile-header-banner">
          <img src="{{ asset('assets/img/backgrounds/jgu.jpg') }}" alt="Banner image" class="rounded-top" style="object-fit: cover; object-position: bottom;">
        </div>
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
          <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img src="{{ asset($user->avatar) }}" alt="user image" class="d-block ms-0 ms-sm-4 rounded user-profile-img">
          </div>
          <div class="flex-grow-1 mt-3 mt-sm-5">
            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
              <div class="user-profile-info">
                <h4>{{ $user->fullname }} @if ($user->role == 'admin' || $user->role == 'bm' || $user->role == "baak")
                  <i class='bx bxs-badge-check text-primary'></i>
                @endif</h4>
                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                  <li class="list-inline-item fw-semibold">
                    <i class='bx bx-buildings'></i> {{ isset($user->department->name) ? $user->department->name : '-' }}
                  </li>
                  <li class="list-inline-item fw-semibold">
                    <i class='bx bx-id-card'></i> {{ $user->nim }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<!--/ Header -->

<!-- User Profile Content -->
<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
      <!-- About User -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="text-muted text-uppercase">Tentang</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span class="fw-semibold mx-2">Nama Lengkap:</span> <span>{{ $user->fullname }}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span class="fw-semibold mx-2">Status:</span> <span>Aktif</span></li>
            <li class="d-flex align-items-center mb-3"><i class="bx bx-star"></i><span class="fw-semibold mx-2">Role:</span> <span>
            @if ($user->role == "user")
                Pengguna
            @elseif ($user->role == "lecturer")
                Dosen
            @elseif ($user->role == "admin")
                Administrator
            @elseif ($user->role == "baak")
                Kepala Biro Administrasi Akademik dan Kemahasiswaan
            @elseif ($user->role == "staff_baak")
                Staff Biro Administrasi Akademik dan Kemahasiswaan
            @else
                Kepala Building Management
            @endif  
            </span></li>
          </ul>
          <small class="text-muted text-uppercase">Kontak</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span class="fw-semibold mx-2">Email:</span> <span>{{ $user->email }}</span></li>
          </ul>
        </div>
      </div>
      <!--/ About User -->
      <!-- Profile Overview -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="text-muted text-uppercase">Ringkasan</small>
          <ul class="list-unstyled mt-3 mb-0">
            <li class="d-flex align-items-center mb-3"><i class="bx bx-calendar-check"></i><span class="fw-semibold mx-2">Peminjaman:</span> <span>{{ count($user->room_reservations->where('status', 'approved')) }}x</span></li>
          </ul>
        </div>
      </div>
      <!--/ Profile Overview -->
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">
      <!-- Activity Timeline -->
      <div class="card card-action mb-4">
        <div class="card-header align-items-center">
          <h5 class="card-action-title mb-0"><i class='bx bx-list-ul me-2'></i>Riwayat Peminjaman</h5>
          <div class="card-action-element">
            <div class="dropdown">
              <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="javascript:void(0);">Share timeline</a></li>
                <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-body">
          <ul class="timeline ms-2">
            @foreach ($user->room_reservations->sortByDesc('id') as $reservation)
            <li class="timeline-item timeline-item-transparent">
              <span class="timeline-point timeline-point-{{ $reservation->status == 'approved' ? 'success' : ($reservation->status == 'pending' ? 'warning' : ($reservation->status == 'cancelled' ? 'primary' : 'danger')) }}"></span>
              <div class="timeline-event">
                <div class="timeline-header mb-1">
                  <h6 class="mb-0">
                    @if ($reservation->status == "approved")
                        Peminjaman Disetujui
                    @elseif ($reservation->status == "pending")
                        Menunggu Konfirmasi
                    @elseif ($reservation->status == "cancelled")
                        Peminjaman Dibatalkan
                    @else
                        Peminjaman Ditolak
                    @endif
                  </h6>
                  <small class="text-muted">{{ $reservation->reservation_date }}</small>
                </div>
                <p class="mb-2">{{ $reservation->status == 'approved' ? 'Telah meminjam' : ($reservation->status == 'pending' ? 'Menunggu konfirmasi' : ($reservation->status == 'cancelled' ? 'Telah membatalkan' : 'SIPERU menolak peminjaman')) }} ruangan {{ $reservation->room->name }} dari jam {{ date("H:i", strtotime($reservation->start_time)) }} - {{ date("H:i", strtotime($reservation->end_time)) }}</p>
                <div class="d-flex flex-wrap">
                  <div class="avatar me-3">
                    <img src="{{ asset($reservation->room->thumbnail) }}" alt="{{ $reservation->room->name }}" class="rounded" style="object-fit: cover" />
                  </div>
                  <div>
                    <h6 class="mb-0">{{ $reservation->room->name }}</h6>
                    <small class="text-muted">{{ $reservation->room->location }} | {{ $reservation->room->capacity }} Orang</small>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <!--/ Activity Timeline -->
    </div>
</div>
<!--/ User Profile Content -->
@endsection
