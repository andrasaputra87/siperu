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
              <span>Jurusan</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ count($tahun_ajaran) }}</h4>
              </div>
              <small>Total tahun ajaran keseluruhan</small>
            </div>
            <span class="badge bg-label-primary rounded p-2">
              <i class="bx bx-calendar-plus bx-sm"></i>
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
                @if ($tahun_ajaran_edit)
                    <form action="{{ route('years.update', $tahun_ajaran_edit) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control @error('tahun_ajaran') border-danger @enderror" placeholder="Masukkan nama ruangan" value="{{ $tahun_ajaran_edit->tahun_ajaran }}">
                                @error('tahun_ajaran')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    </form>
                @else
                    <form action="{{ route('years.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger fw-bold">*</span></label>
                                <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control @error('tahun_ajaran') border-danger @enderror" placeholder="Masukkan tahun ajaran" value="{{ old('tahun_ajaran') }}">
                                @error('tahun_ajaran')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="start_tahun_ajaran" class="form-label">Tanggal Mulai <span class="text-danger fw-bold">*</span></label>
                                <input type="date" name="start_tahun_ajaran" id="start_tahun_ajaran" class="form-control @error('start_tahun_ajaran') border-danger @enderror" value="{{ old('start_tahun_ajaran') }}">
                                @error('start_tahun_ajaran')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="end_tahun_ajaran" class="form-label">Tanggal Berakhir <span class="text-danger fw-bold">*</span></label>
                                <input type="date" name="end_tahun_ajaran" id="end_tahun_ajaran" class="form-control @error('end_tahun_ajaran') border-danger @enderror" value="{{ old('end_tahun_ajaran') }}">
                                @error('end_tahun_ajaran')
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
                                <th>Tahun ajaran</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tahun_ajaran as $tahun)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tahun->tahun_ajaran }}</td>
                                    <td>{{ $tahun->start_tahun_ajaran }}</td>
                                    <td>{{ $tahun->end_tahun_ajaran }}</td>
                                    @if($tahun->status ==0)         
                                        <td><div class="p-3 mb-2 bg-danger text-white">Tidak Aktif</div>
                                        </td>         
                                    @else
                                        <td><div class="p-3 mb-2 bg-success text-black">Aktif</div>
                                    @endif
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('years.edit', $tahun) }}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                                            @if($tahun->status ==0)         
                                                <a href="/set/{{$tahun->id}}" class="btn btn-sm btn-icon item-check-circle"><i class="bx bxs-check-circle"></i></a>
                                            @endif
                                            <form action="{{ route('years.destroy', $tahun) }}" id="delete-form-{{ $tahun->id }}" method="POST">
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
