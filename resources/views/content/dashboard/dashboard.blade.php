@extends('layouts/contentNavbarLayout')

@section('title', 'Beranda')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/chartjs/chartjs.js"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
<script>
  "use strict";
!(function () {
    const o = "#836AF9",
        r = "#ffe800",
        t = "#28dac6",
        e = "#EDF1F4",
        a = "#2B9AFF",
        i = "#84D0FF";
    let l, n, d, s, c;
    document.querySelectorAll(".chartjs").forEach(function (o) {
        o.height = o.dataset.height;
    });
    const p = document.getElementById("barChart");
    if (p) {
      var rooms = @json($rooms);
      var roomNames = rooms.map(room => room.name); // Menyimpan nama ruangan
      var roomReservations = rooms.map(room => {
          var approvedReservations = room.room_reservations.filter(reservation => reservation.status === "approved");
          return approvedReservations.length;
      });

      var maxReservation = Math.max(...roomReservations); // Menemukan nilai maksimum dari array roomReservations

      new Chart(p, {
          type: "bar",
          data: {
              labels: roomNames,
              datasets: [{ data: roomReservations, backgroundColor: t, borderColor: "transparent", maxBarThickness: 15, borderRadius: { topRight: 15, topLeft: 15 } }],
          },
          options: {
              responsive: !0,
              maintainAspectRatio: !1,
              animation: { duration: 500 },
              plugins: { tooltip: { backgroundColor: l, titleColor: n, bodyColor: c, borderWidth: 1, borderColor: s }, legend: { display: !1 } },
              scales: {
                  x: { grid: { color: s, drawBorder: !1, borderColor: s }, ticks: { color: d } },
                  y: { min: 0, max: maxReservation + 5, grid: { color: s, drawBorder: !1, borderColor: s }, ticks: {color: d } } // Menggunakan nilai maksimum yang telah ditemukan
              },
          },
      });
  }

  const g = document.getElementById("polarChart");
    if (g) {
      var departments = @json($departments);
      var departmentNames = departments.map(department => department.name); // Menyimpan nama jurusan
      var departmentUserCounts = departments.map(department => department.users.length);
      new Chart(g, {
          type: "polarArea",
          data: {
              labels: departmentNames,
              datasets: [{ label: "Population (millions)", backgroundColor: [
                          "#4C84FF",
                          "#FF4C5D",
                          "#6EE7B7",
                          "#FFB65D",
                          "#9C6CFF",
                          "#FF8D9C",
                          "#4CFFA8",
                          "#FFCD4C",
                          "#5D9CFF",
                          "#FF6C4C",
                          "#80FF6D",
                          "#FFC34C",
                          "#7A57FF",
                          "#FF6499",
                          "#57FFD9",
                          "#FFA457",
                          "#4F5D70",
                          "#A2AAB2",
                          "#556080",
                          "#8C96A5"
                        ], 
              data: departmentUserCounts, borderWidth: 0 }],
          },
          options: {
              responsive: !0,
              maintainAspectRatio: !1,
              animation: { duration: 500 },
              scales: { r: { ticks: { display: !1, color: d }, grid: { display: !1 } } },
              plugins: {
                  tooltip: { backgroundColor: l, titleColor: n, bodyColor: c, borderWidth: 1, borderColor: s },
                  legend: { position: "right", labels: { usePointStyle: !0, padding: 25, boxWidth: 8, boxHeight: 8, color: c } },
              },
          },
      });
  }

})();

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

<div class="row">
  @if(!auth()->user()->signature)
  <div class="col-12">
    <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert">
      <span class="badge badge-center rounded-pill bg-primary border-label-primary p-3 me-2"><i class="bx bx-error fs-6"></i></span>
      <span>Kami meminta Anda untuk menambahkan tanda tangan Anda ke profil. Tanda tangan ini akan digunakan untuk keperluan administrasi. <a href="/settings" class="fw-bold">Klik disini</a></span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
      </button>
    </div>
  </div>
  @endif
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
  <div class="col-12 order-1">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <span class="avatar flex-shrink-0 badge bg-label-info rounded p-2">
                <i class="bx bx-buildings bx-sm"></i>
              </span>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                  <a class="dropdown-item" href="/building">Lihat Selengkapnya</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Total Gedung</span>
            <h3 class="card-title mb-2">{{ $total_gedung}}</h3>
            <small>Total Gedung yang dimiliki</small>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <span class="avatar flex-shrink-0 badge bg-label-info rounded p-2">
                <i class="bx bx-buildings bx-sm"></i>
              </span>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                  <a class="dropdown-item" href="/rooms">Lihat Selengkapnya</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Total Ruangan</span>
            <h3 class="card-title mb-2">{{ $total_ruangan }}</h3>
            <small>Total ruangan yang dimiliki</small>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <span class="avatar flex-shrink-0 badge bg-label-primary rounded p-2">
                <i class="bx bx-user bx-sm"></i>
              </span>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="/users">Lihat Selengkapnya</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Total Pengguna</span>
            <h3 class="card-title text-nowrap mb-2">{{ $total_pengguna }}</h3>
            <small>Total pengguna saat ini</small>
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
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="/departments">Lihat Selengkapnya</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Total Jurusan</span>
            <h3 class="card-title text-nowrap mb-2">{{ $total_department }}</h3>
            <small>Total jurusan saat ini</small>
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
                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                  <a class="dropdown-item" href="/reservation">Lihat Selengkapnya</a>
                </div>
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Total Peminjaman</span>
            <h3 class="card-title text-nowrap mb-2">{{ $total_reservation }}</h3>
            <small>Total peminjaman dari awal</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bar Charts -->
  <div class="col-12 col-lg-8 order-2 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <h5 class="card-title mb-0">Statistik Peminjaman Ruangan</h5>
        {{-- <div class="card-action-element ms-auto py-0">
          <div class="dropdown">
            <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-calendar"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Today</a></li>
              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Yesterday</a></li>
              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 7 Days</a></li>
              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last 30 Days</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Current Month</a></li>
              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Last Month</a></li>
            </ul>
          </div>
        </div> --}}
      </div>
      <div class="card-body">
        <canvas id="barChart" class="chartjs" data-height="400"></canvas>
      </div>
    </div>
  </div>
  <!-- /Bar Charts -->
  <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header header-elements">
            <h5 class="card-title mb-0">Pengguna per Jurusan</h5>
            {{-- <div class="card-header-elements ms-auto py-0 dropdown">
              <button type="button" class="btn dropdown-toggle hide-arrow p-0" id="heat-chart-dd" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="heat-chart-dd">
                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
              </div>
            </div> --}}
          </div>
          <div class="card-body">
            <canvas id="polarChart" class="chartjs mb-3" data-height="400"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
