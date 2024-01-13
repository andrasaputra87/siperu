@extends('layouts/contentNavbarLayout')

@section('title', 'Data Pengguna')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<style>
    .ijo {
        background-color: rgba(113, 221, 55, 0.2)!important;
    }
</style>
@endsection

@section('vendor-script')
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endsection

@section('page-script')
<script>

    $('.tombol-hapus').on('click', function(e) {
        e.preventDefault();

        const formId = $(this).closest('form').attr('id'); // Mendapatkan ID formulir terkait

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak bisa mengembalikan data kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, hapus!',
            customClass: {
            confirmButton: 'btn btn-primary me-1',
            cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result)  => {
            if (result.isConfirmed) {
                $('#' + formId).submit(); // Mengirimkan formulir jika dikonfirmasi
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
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xxl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Pengguna</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ $users->where('role', 'user')->count() }}</h4>
              </div>
              <small>Total Pengguna</small>
            </div>
            <span class="badge bg-label-primary rounded p-2">
              <i class="bx bx-user bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xxl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Admin Fakultas/BAAK</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ $users->where('role', 'admin_fakultas')->count() }}</h4>
              </div>
              <small>Total Admin Fakultas/BAAK</small>
            </div>
            <span class="badge bg-label-success rounded p-2">
              <i class="bx bxs-user-badge bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xxl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Pengelola Gedung</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ $users->where('role', 'pengelola_gedung')->count() }}</h4>
              </div>
              <small>Total Pengelola Gedung </small>
            </div>
            <span class="badge bg-label-success rounded p-2">
              <i class="bx bxs-user-badge bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="col-sm-6 col-xxl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>BAAK</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ $users->where('role', 'baak')->count() }}</h4>
              </div>
              <small>Total BAAK </small>
            </div>
            <span class="badge bg-label-success rounded p-2">
              <i class="bx bxs-user-badge bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div> -->
    {{-- <div class="col-sm-6 col-xxl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>BM</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ $users->where('role', 'head_bm')->where('role', 'staff_bm')->count() }}</h4>
              </div>
              <small>Total BM </small>
            </div>
            <span class="badge bg-label-success rounded p-2">
              <i class="bx bxs-user-badge bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div> --}}
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary"><i class="bx bx-plus"></i> Tambah Pengguna</a>
                <hr>
                <div class="card-datatable table-responsive">
                    <table class="datatables-basic table border-top" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Jurusan</th>
                                <th>Fakultas/BAAK</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="{{ in_array($user->role, ['admin', 'head_baak', 'head_bm', 'staff_bm', 'staff_baak']) ? 'ijo' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                          <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle" style="object-fit: cover">
                                            </div>
                                          </div>
                                                <div class="d-flex flex-column">
                                                    <a href="/profile/{{ $user->slug }}" class="text-body text-truncate">
                                                        <span class="fw-semibold">{{ $user->fullname }}</span></a>
                                                        <small class="text-muted">{{ $user->nim }}</small>
                                                </div>
                                            </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ isset($user->department->name) ? $user->department->name : '-' }}</td>
                                    <td>{{ isset($user->faculty->name) ? $user->faculty->name : '-' }}</td>
                                    <td>{{ strtoupper(str_replace('_', ' ', $user->role)) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                                            <form action="users/{{ $user->id }}" id="delete-form-{{ $user->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" href="" class="btn btn-sm btn-icon tombol-hapus"><i class="bx bx-trash"></i></button>
                                            </form>
                                            <div class="d-inline-block">
                                                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end m-0">
                                                    <li><a href="/profile/{{ $user->slug }}" class="dropdown-item">Rincian</a></li>
                                                </ul>
                                            </div>
                                        </div>
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
<!--/ DataTable with Buttons -->
@endsection
