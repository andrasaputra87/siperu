@extends('layouts/contentNavbarLayout')

@section('title', 'Beranda')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/chartjs/chartjs.js">
    </script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
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
        <div id="toast" class="bs-toast toast toast-placement-ex m-2 fade bg-success top-0 end-0 show" role="alert"
            aria-live="assertive" aria-atomic="true">
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

    <div class="row">
        @if (!auth()->user()->signature)
            <div class="col-12">
                <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert">
                    <span class="badge badge-center rounded-pill bg-primary border-label-primary p-3 me-2"><i
                            class="bx bx-error fs-6"></i></span>
                    <span>Kami meminta Anda untuk menambahkan tanda tangan Anda ke profil. Tanda tangan ini akan digunakan
                        untuk keperluan administrasi. <a href="/settings" class="fw-bold">Klik disini</a></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            </div>
        @endif
        @if (auth()->user()->role == 'user')
            
        
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
              <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                  <div class="card-body">
                    <h5 class="card-title text-primary">Selamat Datang {{ Auth()->user()->fullname }} 🎉</h5>
                    <p class="mb-4">Ayo mulai pinjam ruangan dengan mudah dan nyaman.</p>
        
                    <a href="building_view" class="btn btn-sm btn-outline-primary">Pinjam Ruangan</a>
                  </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                  <div class="card-body pb-0 px-0 px-md-4">
                    <img src="{{asset('assets/img/illustrations/man-with-laptop-light.png')}}" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif

        <div class="col-12 order-1">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <span class="avatar flex-shrink-0 badge bg-label-primary rounded p-2">
                                    <i class="bx bx-buildings bx-sm"></i>
                                </span>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="/room_reservation">Lihat Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Ruangan Tersedia</span>
                            <h3 class="card-title text-nowrap mb-2">{{ $ruangan_tersedia }}</h3>
                            <small>Ruangan tersedia saat ini</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <span class="avatar flex-shrink-0 badge bg-label-info rounded p-2">
                                    <i class='bx bxs-calendar'></i>
                                </span>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="/rooms">Lihat Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Total Peminjaman</span>
                            <h3 class="card-title mb-2">{{ $peminjaman->count() }}</h3>
                            <small>Total peminjaman</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <span class="avatar flex-shrink-0 badge bg-label-warning rounded p-2">
                                    <i class="bx bx-building bx-sm"></i>
                                </span>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="/departments">Lihat Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Peminjaman Disetujui</span>
                            <h3 class="card-title text-nowrap mb-2">{{ $peminjaman->where('status', 'approved')->count() }}
                            </h3>
                            <small>Total peminjaman disetujui</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <span class="avatar flex-shrink-0 badge bg-label-success rounded p-2">
                                    <i class="bx bx-calendar-check bx-sm"></i>
                                </span>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="/reservation">Lihat Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Peminjaman Ditolak</span>
                            <h3 class="card-title text-nowrap mb-2">
                                {{ $peminjaman->where('status', 'not approved')->count() }}</h3>
                            <small>Total peminjaman ditolak</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <span class="avatar flex-shrink-0 badge bg-label-warning rounded p-2">
                                    <i class="bx bx-calendar-check bx-sm"></i>
                                </span>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="/reservation">Lihat Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Peminjaman Dijadwalakn Ulang</span>
                            <h3 class="card-title text-nowrap mb-2">
                                {{ $peminjaman->where('status', 'reschedule')->count() }}</h3>
                            <small>Total peminjaman direschedule</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body p-5">
                        @if ($peminjaman->isEmpty())
                            <div class="text-center">
                                <h2 class="text-primary">Riwayat Peminjaman Kosong!</h2>
                                <p class="mb-5">Ayo, manfaatkan fasilitas yang kami sediakan untuk kegiatan Anda.</p>
                                <img src="{{ asset('assets/img/illustrations/page-misc-error-light.png') }}"
                                    alt="" class="img-fluid" width="500">
                            </div>
                        @else
                            <ul class="timeline ms-2">
                                @foreach ($peminjaman->sortByDesc('id') as $reservation)
                                    <li class="timeline-item timeline-item-transparent">
                                        <span
                                            class="timeline-point timeline-point-{{ $reservation->status == 'approved' ? 'success' : ($reservation->status == 'pending' ? 'warning' : ($reservation->status == 'cancelled' ? 'primary' : 'danger')) }}"></span>
                                        <div class="timeline-event">
                                            <div class="timeline-header mb-1">
                                                <h6 class="mb-0">
                                                    @if ($reservation->status == 'approved')
                                                        Peminjaman Disetujui
                                                    @elseif ($reservation->status == 'reschedule')
                                                        Jadwalkan ulang
                                                    @elseif ($reservation->status == 'pending')
                                                        Menunggu Konfirmasi
                                                    @elseif ($reservation->status == 'cancelled')
                                                        Peminjaman Dibatalkan
                                                    @else
                                                        Peminjaman Ditolak
                                                    @endif
                                                </h6>
                                                <small class="text-muted">{{ $reservation->reservation_date }}</small>
                                            </div>
                                            <p class="mb-2">
                                                {{ $reservation->status == 'approved'
                                                    ? 'Telah meminjam'
                                                    : ($reservation->status == 'pending'
                                                        ? 'Menunggu konfirmasi'
                                                        : ($reservation->status == 'reschedule'
                                                            ? 'Jadwalkan Ulang'
                                                            : ($reservation->status == 'cancelled'
                                                                ? 'Telah membatalkan'
                                                                : 'SIPERU menolak peminjaman'))) }}
                                                ruangan {{ $reservation->room->name }} dari jam
                                                {{ date('H:i', strtotime($reservation->session->start)) }} -
                                                {{ date('H:i', strtotime($reservation->end_time)) }}</p>
                                            <div class="d-flex flex-wrap">
                                                <div class="avatar me-3">
                                                    <img src="{{ asset($reservation->room->thumbnail) }}"
                                                        alt="{{ $reservation->room->name }}" class="rounded"
                                                        style="object-fit: cover" />
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $reservation->room->name }}</h6>
                                                    <small class="text-muted">{{ $reservation->room->location }} |
                                                        {{ $reservation->room->capacity }} Orang</small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                <li class="timeline-end-indicator">
                                    <i class="bx bx-check-circle"></i>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
