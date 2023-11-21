@extends('layouts/contentNavbarLayout')

@section('title', 'Data Ruangan')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/dropzone/dropzone.css" />
@endsection

@section('vendor-script')
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
    var dropzone = new Dropzone("#dropzone-multi", {
        maxFileSize: 3,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        dictRemoveFile: "Hapus",
        dictFileTooBig: "Ukuran file terlalu besar",
        dictInvalidFileType: "Ekstensi file tidak diperbolehkan",
    });
</script>
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                    <img src="{{ asset($room->thumbnail) }}" alt="{{ asset($room->name) }}" class="rounded me-3" width="150px" height="100px" style="object-fit: cover;">
                        <div class="">
                            <h5 class="card-title text-primary">{{ $room->name }}</h5>
                            <p class="card-text">{{ $room->description }}</p>
                            <div class="d-flex gap-2 mb-3 flex-wrap">
                                @if ($room->availability == 1)
                                    <span class="badge bg-label-success">Tersedia</span>
                                @else
                                <span class="badge bg-label-danger">Tidak Tersedia</span>
                                @endif
                                <span class="badge bg-label-primary">{{ $room->location }}</span>
                                <span class="badge bg-label-primary">{{ $room->capacity }} Orang</span>
                            </div>
                        </div>
                    </div>
                    <div class="float-left">
                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-show-alt me-1"></i>
                            Lihat Ruangan
                        </a>
                        <a href="#"></a>
                    </div>
                </div>
                <hr>
                <form action="/upload-slider/{{ $room->id }}" class="dropzone" id="dropzone-multi" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="dz-message">
                    Jatuhkan file disini atau klik untuk mengunggah
                      <span class="note">(Hanya menerima gambar <strong>tidak</strong> menerima video.)</span>
                    </div>
                    <div class="fallback">
                      <input name="file" type="file" />
                    </div>
                </form>

                <div class="card-datatable table-responsive">
                    <table class="datatables-basic table border-top" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Slide</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($room->roomImages as $image)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Slide {{ $loop->iteration }}</td>
                                    <td><img src="{{ asset($image->filename) }}" width="150px" height="100px" class="rounded" style="object-fit: cover;"></td>
                                    <td>
                                        <div class="d-flex">
                                            <form action="/delete-slider/{{ $image->id }}" id="delete-form-{{ $image->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" href="" class="btn btn-sm btn-icon tombol-hapus"><i class="bx bx-trash"></i></button>
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
