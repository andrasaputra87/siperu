@extends('layouts/contentNavbarLayout')

@section('title', 'Data Jurusan')

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

<div class="row g-4 mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Fakultas</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ count($faculties) }}</h4>
              </div>
              <small>Total fakultas keseluruhan</small>
            </div>
            <span class="badge bg-label-primary rounded p-2">
              <i class="bx bx-building bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- DataTable with Buttons -->
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                @if ($faculty_edit)
                    <form action="{{ route('faculties.update', $faculty_edit) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Nama Fakultas <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') border-danger @enderror" placeholder="Masukkan nama ruangan" value="{{ $faculty_edit->name }}">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="dekan" class="form-label">Ketua Fakultas <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="dekan" id="dekan" class="form-control @error('dekan') border-danger @enderror" placeholder="Masukkan nama ruangan" value="{{ $faculty_edit->dekan }}">
                                @error('dekan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    </form>
                @else
                    <form action="{{ route('faculties.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Nama Fakultas <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') border-danger @enderror" placeholder="Masukkan nama fakultas" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="dekan" class="form-label">Ketua Fakultas <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="dekan" id="dekan" class="form-control @error('dekan') border-danger @enderror" placeholder="Masukkan dekan" value="{{ old('head_of_deparment') }}">
                                @error('dekan')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                {{-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bx bx-plus"></i> Tambah Ruangan</button> --}}
                {{-- <hr> --}}
                <div class="card-datatable table-responsive">
                    <table class="datatables-basic table border-top" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Dekan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faculties as $faculty)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $faculty->name }}</td>
                                    <td>{{ $faculty->dekan }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                                            <form action="{{ route('faculties.destroy', $faculty) }}" id="delete-form-{{ $faculty->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon tombol-hapus"><i class="bx bx-trash"></i></button>
                                            </form>
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
