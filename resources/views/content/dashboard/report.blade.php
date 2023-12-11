@extends('layouts/contentNavbarLayout')

@section('title', 'Data Pengguna')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
@endsection

@section('vendor-script')
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endsection

@section('page-script')
<script>

    $('.setuju').on('click', function(e) {
        e.preventDefault();

        const href = $(this).attr('href');

        Swal.fire({
            title: 'Apakah anda setuju?',
            text: "Anda tidak bisa mengembalikan aksi anda!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, setuju!',
            customClass: {
            confirmButton: 'btn btn-primary me-1',
            cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result)  => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });
    
    $('.tidak-setuju').on('click', function(e) {
        e.preventDefault();

        const href = $(this).attr('href');

        Swal.fire({
            title: 'Apakah anda tidak setuju?',
            text: "Anda tidak bisa mengembalikan aksi anda!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, tidak setuju!',
            customClass: {
            confirmButton: 'btn btn-primary me-1',
            cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result)  => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    });


    var dt_basic_table = $('.datatables-basic');
    var dt_basic = dt_basic_table.DataTable({
        language: {
            "sEmptyTable": "Tidak ada data yang tersedia",
            "sInfo": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
            "sInfoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari total _MAX_ entri)",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": "Tampilkan _MENU_ entri",
            "sLoadingRecords": "Memuat...",
            "sProcessing": "Memproses...",
            "sSearch": "Cari:",
            "sZeroRecords": "Tidak ditemukan data yang sesuai",
            "oPaginate": {
                "sFirst": "Pertama",
                "sLast": "Terakhir",
                "sNext": "Selanjutnya",
                "sPrevious": "Sebelumnya"
            },
            "oAria": {
                "sSortAscending": ": aktifkan untuk mengurutkan kolom secara ascending",
                "sSortDescending": ": aktifkan untuk mengurutkan kolom secara descending"
            },
            "sSortAscending": " (aktifkan untuk mengurutkan kolom secara ascending)",
            "sSortDescending": " (aktifkan untuk mengurutkan kolom secara descending)"
        }
    });

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

<!-- DataTable with Buttons -->
{{-- <div class="row g-4 mb-4">
  
    
</div> --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="/report" method="GET">
                  <div class="row align-items-end">
                    <div class="col-md-6 col-lg-4 col-xxl-4 mb-2">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Awal</label>
                        <input type="date" name="start_date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $startDate }}">
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xxl-4 mb-2">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" id="exampleInputPassword1" value="{{ $endDate }}">
                      </div>
                    </div>
                    <div class="col-md-2 mb-2">
                      <div class="d-flex">
                        <button type="submit" class="btn btn-primary me-2"><i class='bx bx-filter-alt me-1'></i> Filter</button>
                        <button type="reset" class="btn btn-danger"><i class='bx bx-eraser me-1'></i> Bersihkan</button>
                      </div>
                    </div>
                  </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-12">
                    <a href="/export" class="btn btn-sm btn-primary ms-4"><i class='bx bxs-file-export me-1'></i> Ekspor Semua</a>
                    <hr class="mx-4">
                  </div>
                </div>
                <div class="row mx-2">
                  <div class="card-datatable table-responsive">
                      <table class="datatables-basic table border-top" id="myTable">
                          <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Peminjam</th>
                                  <th>Gedung</th>
                                  <th>Ruangan</th>
                                  <th>Tanggal Peminjaman</th>
                                  <th>Waktu Mulai</th>
                                  <th>Waktu Selesai</th>
                                  <th>Keperluan</th>
                                  
                                  <th>Status</th>
                                  <th>Aksi</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($reservations as $reservation)
                                  <tr>
                                      <td>{{ $loop->iteration }}</td>
                                      <td>
                                          <div class="d-flex justify-content-start align-items-center user-name"><div class="avatar-wrapper">
                                              <div class="avatar avatar-sm me-3">
                                                  <img src="{{ asset($reservation->user->avatar) }}" alt="{{ $reservation->user->fullname }}" class="rounded-circle" style="object-fit: cover">
                                              </div>
                                              </div>
                                                  <div class="d-flex flex-column">
                                                      <a href="/profile/{{ $reservation->user->slug }}" class="text-body text-truncate">
                                                          <span class="fw-semibold">{{ $reservation->user->fullname }}</span></a>
                                                          <small class="text-muted">{{ $reservation->user->nim }}</small>
                                                  </div>
                                              </div>
                                      </td>
                                      <td>{{ $reservation->room->building->building_name }}</td>
                                      <td>{{ $reservation->room->name }}</td>
                                      <td>{{ $reservation->reservation_date }}</td>
                                      <td>{{ substr($reservation->session->start, 0, 5) }}</td>
                                      <td>{{ substr($reservation->end_time, 0, 5) }}</td>
                                      <td>
                                          @if(strlen($reservation->necessary) > 35)
                                              {{ substr($reservation->necessary, 0, 35) . "..." }}
                                          @else
                                              {{ $reservation->necessary }}
                                          @endif
                                      </td>
                                     
                                      <td>
                                          @if ($reservation->room->ownership == 'baak')
                                              @if ($reservation->status == 'approved')
                                              <span class="badge bg-success">Disetujui</span>
                                              @elseif ($reservation->status == 'not approved')
                                                  <span class="badge bg-danger">Ditolak</span>
                                              @elseif($reservation->status == 'cancelled')
                                                  <span class="badge bg-danger">Dibatalkan</span>
                                              @else
                                                  <span class="badge bg-warning">Pending</span>
                                              @endif
                                          @else
                                              @if ($reservation->status == 'approved')
                                              <span class="badge bg-success">Disetujui</span>
                                              @elseif ($reservation->status == 'not approved')
                                                  <span class="badge bg-danger">Ditolak</span>
                                              @elseif($reservation->status == 'cancelled')
                                                  <span class="badge bg-danger">Dibatalkan</span>
                                              @else
                                                  <span class="badge bg-warning">Pending</span>
                                              @endif
                                          @endif
                                      </td>
                                      <td>
                                          -
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ DataTable with Buttons -->
@endsection
