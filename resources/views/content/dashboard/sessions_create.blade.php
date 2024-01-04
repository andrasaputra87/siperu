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
@elseif (session()->has('message_danger'))
<div id="toast" class="bs-toast toast toast-placement-ex m-2 fade bg-danger top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <i class="bx bx-bell me-2"></i>
      <div class="me-auto fw-semibold">Gagal!</div>
      <small>Baru saja</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{ session('message_danger') }}
    </div>
</div>
@endif

<div class="row g-4 mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Sesi Waktu</span>
              <div class="d-flex align-items-end mt-2">
                <h4 class="mb-0 me-2">{{ count($sessions) }}</h4>
              </div>
              <small>Total sesi waktu keseluruhan</small>
            </div>
            <span class="badge bg-label-primary rounded p-2">
              <i class="bx bx-timer bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- DataTable with Buttons -->
@if ($sessions_edit!='' or count($sessions)==0)

<div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    @if ($sessions_edit)
                        <form action="{{ route('sessions.update', $sessions_edit) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nama" class="form-label">Nama <span class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control @error('nama') border-danger @enderror" placeholder="Masukkan nama ruangan" value="{{ $sessions_edit->nama }}" @disabled(true)>
                                    @error('nama')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label for="start" class="form-label">Waktu Mulai Sesi <span class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="start" id="start" class="form-control @error('start') border-danger @enderror" placeholder="Masukkan nama ruangan" value="{{ $sessions_edit->start }}" @disabled(true)>
                                    @error('start')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label for="mon" class="form-label">Senin <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control" name="mon">
                                          <option value="0" {{ ( $sessions_edit->mon == 0) ? 'selected' : '' }}> Tutup</option>
                                          <option value="1" {{ ( $sessions_edit->mon == 1) ? 'selected' : '' }}> Buka</option>
                                    </select>
                                    @error('mon')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label for="tue" class="form-label">Selasa <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control" name="tue">
                                          <option value="0" {{ ( $sessions_edit->tue == 0) ? 'selected' : '' }}> Tutup</option>
                                          <option value="1" {{ ( $sessions_edit->tue == 1) ? 'selected' : '' }}> Buka</option>
                                    </select>
                                    @error('tue')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label for="wed" class="form-label">Rabu <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control" name="wed">
                                          <option value="0" {{ ( $sessions_edit->wed == 0) ? 'selected' : '' }}> Tutup</option>
                                          <option value="1" {{ ( $sessions_edit->wed == 1) ? 'selected' : '' }}> Buka</option>
                                    </select>
                                    @error('wed')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label for="thu" class="form-label">Kamis <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control" name="thu">
                                          <option value="0" {{ ( $sessions_edit->thu == 0) ? 'selected' : '' }}> Tutup</option>
                                          <option value="1" {{ ( $sessions_edit->thu == 1) ? 'selected' : '' }}> Buka</option>
                                    </select>
                                    @error('thu')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label for="fri" class="form-label">Jum'at <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control" name="fri">
                                          <option value="0" {{ ( $sessions_edit->fri == 0) ? 'selected' : '' }}> Tutup</option>
                                          <option value="1" {{ ( $sessions_edit->fri == 1) ? 'selected' : '' }}> Buka</option>
                                    </select>
                                    @error('fri')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label for="sat" class="form-label">Sabtu <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control" name="sat">
                                          <option value="0" {{ ( $sessions_edit->sat == 0) ? 'selected' : '' }}> Tutup</option>
                                          <option value="1" {{ ( $sessions_edit->sat == 1) ? 'selected' : '' }}> Buka</option>
                                    </select>
                                    @error('sat')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                    <label for="status" class="form-label">Status <span class="text-danger fw-bold">*</span></label>
                                    <select class="form-control" name="status">
                                          <option value="0" {{ ( $sessions_edit->status == 0) ? 'selected' : '' }}> Tidak Aktif</option>
                                          <option value="1" {{ ( $sessions_edit->status == 1) ? 'selected' : '' }}> Aktif </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            {{-- <button type="reset" class="btn btn-danger btn-sm">Reset</button> --}}
                        </form>
                    @endif
                    @if (count($sessions)==0)
                        <form action="{{ route('sessions.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id_tahun_ajaran" id="id_tahun_ajaran"  value="{{ $tahun_ajaran_id }}">
                                <div class="col mb-3">
                                    <label class="form-label" for="start">Atur Waktu Sesi Awal Peminjaman Ruangan</label>
                                    <input type="time" id="start" name="start"
                                        class="form-control @error('start') border-danger @enderror"
                                        value="{{ old('start') }}" />
                                    @error('start')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col mb-3">
                                    <label class="form-label" for="end">Atur Waktu Tutup Peminjaman Ruangan</label>
                                    <input type="time" id="end" name="end"
                                        class="form-control @error('end') border-danger @enderror"
                                        value="{{ old('end') }}" />
                                    @error('end')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Generate Sesi</button>
                            <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-10">
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
                                    <th>Waktu Mulai Sesi</th>
                                    <th>Senin</th>
                                    <th>Selasa</th>
                                    <th>Rabu</th>
                                    <th>Kamis</th>
                                    <th>Jum'at</th>
                                    <th>Sabtu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $session->nama }}</td>
                                        <td>{{ $session->start }}</td>
                                        <td><input type="checkbox" name="mon" data-plugin="switchery" data-color="#1bb99a"   {{  ($session->mon == 1 ? ' checked' : '') }} @disabled(true)></td>         
                                        <td><input type="checkbox" name="tue" data-plugin="switchery" data-color="#1bb99a"   {{  ($session->tue == 1 ? ' checked' : '') }} @disabled(true)></td>         
                                        <td><input type="checkbox" name="wed" data-plugin="switchery" data-color="#1bb99a"   {{  ($session->wed == 1 ? ' checked' : '') }} @disabled(true)></td>         
                                        <td><input type="checkbox" name="thu" data-plugin="switchery" data-color="#1bb99a"   {{  ($session->thu == 1 ? ' checked' : '') }} @disabled(true)></td>         
                                        <td><input type="checkbox" name="fri" data-plugin="switchery" data-color="#1bb99a"   {{  ($session->fri == 1 ? ' checked' : '') }} @disabled(true)></td>         
                                        <td><input type="checkbox" name="sat" data-plugin="switchery" data-color="#1bb99a"   {{  ($session->sat == 1 ? ' checked' : '') }} @disabled(true)></td>         

                                        @if($session->status ==0)         
                                            <td><div class="p-3 mb-2 bg-danger text-white">Tidak Aktif</div>
                                            </td>         
                                        @else
                                            <td><div class="p-3 mb-2 bg-success text-black">Aktif</div>
                                        @endif
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('sessions.edit', $session) }}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                                                {{-- <a href="/set/{{$session->id}}" class="btn btn-sm btn-icon item-check-circle"><i class="bx bxs-check-circle"></i></a> --}}
                                                <form action="{{ route('sessions.destroy', $session) }}" id="delete-form-{{ $session->id }}" method="POST">
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
