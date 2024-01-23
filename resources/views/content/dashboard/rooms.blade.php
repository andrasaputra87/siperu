@extends('layouts/contentNavbarLayout')

@section('title', 'Data Ruangan')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <style>
        /* 1.14 Image Preview */
        .image-preview,
        #callback-preview {
            width: 250px;
            height: 250px;
            border: 2px dashed #ddd;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
            background-color: #ffffff;
            color: #ecf0f1;
        }

        .image-preview input,
        #callback-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }

        .image-preview label,
        #callback-preview label {
            position: absolute;
            z-index: 5;
            opacity: 0.8;
            cursor: pointer;
            background-color: #bdc3c7;
            width: 150px;
            height: 50px;
            font-size: 12px;
            line-height: 50px;
            text-transform: uppercase;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
        }
    </style>
@endsection

@section('vendor-script')
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js">
    </script>
    <script src="https://demo.getstisla.com/assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
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
            }).then((result) => {
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

        $.uploadPreview({
            input_field: "#image-upload", // Default: .image-upload
            preview_box: "#image-preview", // Default: .image-preview
            label_field: "#image-label", // Default: .image-label
            label_default: "Pilih File", // Default: Choose File
            label_selected: "Ubah File", // Default: Change File
            no_label: false, // Default: false
            success_callback: null // Default: null
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

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Ruangan</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ count($rooms) }}</h4>
                            </div>
                            <small>Total ruangan keseluruhan</small>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-buildings bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Tersedia</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $room_available }}</h4>
                                <small
                                    class="text-success">({{ count($rooms) > 0 ? ($room_available / count($rooms)) * 100 . '%' : '0%' }})</small>
                            </div>
                            <small>Ruangan yang tersedia</small>
                        </div>
                        <span class="badge bg-label-success rounded p-2">
                            <i class="bx bx-buildings bx-sm"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>Tidak Tersedia</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2">{{ $room_not_available }}</h4>
                                <small
                                    class="text-danger">({{ count($rooms) > 0 ? ($room_not_available / count($rooms)) * 100 . '%' : '0%' }})</small>
                            </div>
                            <small>Ruang yang sedang dipinjam</small>
                        </div>
                        <span class="badge bg-label-danger rounded p-2">
                            <i class="bx bx-buildings bx-sm"></i>
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
                    @if ($room_edit)
                        <form action="{{ route('rooms.update', $room_edit) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="building" class="form-label">Gedung <span
                                            class="text-danger fw-bold">*</span></label>
                                    <select name="building" id="building1"
                                        class="form-select @error('building') border-danger @enderror">
                                        <option value="" selected disabled>-- Pilih Lokasi --</option>
                                        <?php $lantai = 0; ?>
                                        @foreach ($building as $build)
                                            <?php $lantai = (int) ($build->id == $room_edit->building_id ? $build->floor : $lantai); ?>
                                            <option value="{{ $build->id }}"
                                                {{ $build->id == $room_edit->building_id ? 'selected' : '' }}>
                                                {{ $build->building_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('building')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="name" class="form-label">Nama Ruangan <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') border-danger @enderror"
                                        placeholder="Masukkan nama ruangan" value="{{ $room_edit->name }}">
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6 mb-0">
                                    <label for="capacity" class="form-label">Kapasitas <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="number" name="capacity" id="capacity"
                                        class="form-control @error('capacity') border-danger @enderror"
                                        placeholder="Masukkan kapasitas (orang)" value="{{ $room_edit->capacity }}">
                                    @error('capacity')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="location" class="form-label">Lokasi<span
                                            class="text-danger fw-bold">*</span></label>
                                    <select name="location" id="location1"
                                        class="form-select @error('location') border-danger @enderror">
                                        <?php
                                        if ($lantai === 0) {
                                            ?>
                                        <option value="Lantai 0" selected disabled>-- Pilih Lokasi --</option>
                                        <?php
                                        } else{
                                            for ($i=0; $i < $lantai; $i++) { 
                                                ?>
                                        <option value="Lantai <?= $i + 1 ?>"
                                            <?= $room_edit->location == 'Lantai ' . ($i + 1) ? 'selected' : '' ?>>Lantai
                                            <?= $i + 1 ?></option>
                                        <?php
                                            }
                                        ?>
                                        <?php  } ?>
                                    </select>
                                    @error('location')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="description" class="form-label">Deskripsi <span
                                            class="text-danger fw-bold">*</span></label>
                                    <textarea name="description" id="description" cols="30" rows="10"
                                        class="form-control @error('description') border-danger @enderror">{{ $room_edit->description }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="kursi_kuliah" class="form-label">Fasilitas Kursi Kuliah</label>
                                    <input type="number" name="kursi_kuliah" id="kursi_kuliah"
                                        class="form-control @error('kursi_kuliah') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ $room_edit->kursi_kuliah }}">
                                    @error('kursi_kuliah')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="kursi_dosen" class="form-label">Fasilitas Kursi Desan</label>
                                    <input type="text" name="kursi_dosen" id="kursi_dosen"
                                        class="form-control @error('kursi_dosen') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ $room_edit->kursi_dosen }}">
                                    @error('kursi_dosen')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="meja_dosen" class="form-label">Fasilitas Meja Dosen</label>
                                    <input type="text" name="meja_dosen" id="meja_dosen"
                                        class="form-control @error('meja_dosen') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ $room_edit->meja_dosen }}">
                                    @error('meja_dosen')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="ac" class="form-label">Fasilitas AC</label>
                                    <input type="text" name="ac" id="ac"
                                        class="form-control @error('ac') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ $room_edit->ac }}">
                                    @error('ac')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="kipas_angin" class="form-label">Fasilitas Kipas Angin</label>
                                    <input type="text" name="kipas_angin" id="kipas_angin"
                                        class="form-control @error('kipas_angin') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ $room_edit->kipas_angin }}">
                                    @error('kipas_angin')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="whiteboard" class="form-label">Fasilitas Whiteboard</label>
                                    <input type="text" name="whiteboard" id="whiteboard"
                                        class="form-control @error('whiteboard') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ $room_edit->whiteboard }}">
                                    @error('whiteboard')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="penghapus" class="form-label">Fasilitas Penghapus</label>
                                    <input type="text" name="penghapus" id="penghapus"
                                        class="form-control @error('penghapus') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ $room_edit->penghapus }}">
                                    @error('penghapus')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="proyektor" class="form-label">Fasilitas Proyektor</label>
                                    <input type="text" name="proyektor" id="proyektor"
                                        class="form-control @error('proyektor') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ $room_edit->proyektor }}">
                                    @error('proyektor')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <img src="{{ asset($room_edit->thumbnail) }}" alt="{{ $room_edit->name }}"
                                class=" rounded mb-3 shadow-sm"
                                style="width: 70%; height: 40%; border: 1px solid #d9dee3;">
                            <div class="row mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail <span
                                        class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-12">
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">Pilih File</label>
                                        <input type="file" name="thumbnail" id="image-upload">
                                    </div>
                                </div>
                                @error('thumbnail')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                        </form>
                    @else
                        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="building" class="form-label">Gedung <span
                                            class="text-danger fw-bold">*</span></label>
                                    <select name="building" id="building" onchange="myFunction()"
                                        class="form-select @error('building') border-danger @enderror">
                                        <option value="" selected disabled>-- Pilih Gedung --</option>

                                        @foreach ($building as $build)
                                            <option value="{{ $build->id }}">{{ $build->building_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('building')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="name" class="form-label">Nama Ruangan <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') border-danger @enderror"
                                        placeholder="Masukkan nama ruangan" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6 mb-0">
                                    <label for="capacity" class="form-label">Kapasitas <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="number" name="capacity" id="capacity"
                                        class="form-control @error('capacity') border-danger @enderror"
                                        placeholder="Masukkan kapasitas (orang)" value="{{ old('capacity') }}">
                                    @error('capacity')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-0">
                                    <label for="location" class="form-label">Lokasi <span
                                            class="text-danger fw-bold">*</span></label>
                                    <select name="location" id="location"
                                        class="form-select @error('location') border-danger @enderror">

                                        <option value="" selected disabled>-- Pilih Lokasi --</option>
                                    </select>
                                    @error('location')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="description" class="form-label">Deskripsi <span
                                            class="text-danger fw-bold">*</span></label>
                                    <textarea name="description" id="description" cols="30" rows="10"
                                        class="form-control @error('description') border-danger @enderror">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="kursi_kuliah" class="form-label">Fasilitas Kursi Kuliah</label>
                                    <input type="number" name="kursi_kuliah" id="kursi_kuliah"
                                        class="form-control @error('kursi_kuliah') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ old('kursi_kuliah') }}">
                                    @error('kursi_kuliah')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="kursi_dosen" class="form-label">Fasilitas Kursi Desan</label>
                                    <input type="text" name="kursi_dosen" id="kursi_dosen"
                                        class="form-control @error('kursi_dosen') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ old('kursi_dosen') }}">
                                    @error('kursi_dosen')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="meja_dosen" class="form-label">Fasilitas Meja Dosen</label>
                                    <input type="text" name="meja_dosen" id="meja_dosen"
                                        class="form-control @error('meja_dosen') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ old('meja_dosen') }}">
                                    @error('meja_dosen')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="ac" class="form-label">Fasilitas AC</label>
                                    <input type="text" name="ac" id="ac"
                                        class="form-control @error('ac') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ old('ac') }}">
                                    @error('ac')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="kipas_angin" class="form-label">Fasilitas Kipas Angin</label>
                                    <input type="text" name="kipas_angin" id="kipas_angin"
                                        class="form-control @error('kipas_angin') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ old('kipas_angin') }}">
                                    @error('kipas_angin')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="whiteboard" class="form-label">Fasilitas Whiteboard</label>
                                    <input type="text" name="whiteboard" id="whiteboard"
                                        class="form-control @error('whiteboard') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ old('whiteboard') }}">
                                    @error('whiteboard')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="penghapus" class="form-label">Fasilitas Penghapus</label>
                                    <input type="text" name="penghapus" id="penghapus"
                                        class="form-control @error('penghapus') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ old('penghapus') }}">
                                    @error('penghapus')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="proyektor" class="form-label">Fasilitas Proyektor</label>
                                    <input type="text" name="proyektor" id="proyektor"
                                        class="form-control @error('proyektor') border-danger @enderror"
                                        placeholder="Masukkan jumlah" value="{{ old('proyektor') }}">
                                    @error('proyektor')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="thumbnail" class="form-label">Thumbnail <span
                                        class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-12">
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">Pilih File</label>
                                        <input type="file" name="thumbnail" id="image-upload">
                                    </div>
                                </div>
                                @error('thumbnail')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
                                    <th>Thumbnail</th>
                                    <th>Nama</th>
                                    <th>Kapasitas</th>
                                    <th>Gedung</th>
                                    <th>Fasilitas</th>
                                    <th>Lokasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $room)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset($room->thumbnail) }}" alt="{{ $room->name }}"
                                                style="width: 70px; height: 70px; object-fit:cover"></td>
                                        <td><b>{{ $room->name }}</b>
                                            {{-- <small
                                                class="text-muted d-block">({{ strtoupper($room->ownership) }})</small> --}}
                                        </td>
                                        <td>{{ $room->capacity }} Orang</td>
                                        <td>{{ $room->building->building_name }}</td>
                                        <td >
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCenter">
                                               Cek
                                              </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="modalCenterTitle">Fasilitas Ruangan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-group">
                                                                <li class="list-group-item">Kursi Kuliah : {{ $room->kursi_kuliah}}</li>
                                                                <li class="list-group-item">Kursi Dosen : {{ $room->kursi_dosen}}</li>
                                                                <li class="list-group-item">Meja Dosen : {{ $room->meja_dosen}}</li>
                                                                <li class="list-group-item">AC : {{ $room->ac}}</li>
                                                                <li class="list-group-item">Kipas Angin : {{ $room->kipas_angin}}</li>
                                                                <li class="list-group-item">White Board : {{ $room->whiteboard}}</li>
                                                                <li class="list-group-item">Penghapus : {{ $room->penghapus}}</li>
                                                                <li class="list-group-item">Proyektor : {{ $room->proyektor}}</li>
                                                              </ul>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                        </td>
                                        <td>
                                            @if ($room->location == '')
                                                <span class="bagde bg-danger">Tidak Bertingkat</span>
                                            @else
                                                {{ $room->location }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($room->availability == '1')
                                                <span class="badge bg-success">Tersedia</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                {{-- {{ $room->id_room }} --}}
                                                @if($room->availability ==0)         
                                                    <a href="/set_room/{{$room->id}}" class="btn btn-sm btn-icon item-check-circle"><i class="bx bxs-check-circle"></i></a>
                                                @else
                                                    <a href="/set_room_non/{{$room->id}}" class="btn btn-sm btn-icon item-check-circle"><i class="bx bxs-checkbox-minus"></i></a>
                                                @endif
                                                <a href="{{ route('rooms.edit', $room) }}"
                                                    class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                                                <form action="{{ route('rooms.destroy', $room) }}"
                                                    id="delete-form-{{ $room->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" href=""
                                                        class="btn btn-sm btn-icon tombol-hapus"><i
                                                            class="bx bx-trash"></i></button>
                                                </form>
                                                <div class="d-inline-block">
                                                    <a href="javascript:;"
                                                        class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end m-0">
                                                        <li><a href="/rooms/{{ $room->id }}"
                                                                class="dropdown-item">Details</a></li>
                                                        <li><a href="/add-slider/{{ $room->id }}"
                                                                class="dropdown-item">Tambah foto slider</a></li>
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
        </div><!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modal Header</h4>
              </div>
              <div class="modal-body">
                <p>Some text in the modal.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        
          </div>
        </div>

        
    </div>

   

    <script>
        const dataBuilding = JSON.parse(`<?= json_encode($building) ?>`);
        @if ($room_edit)
            const buildingInput1 = document.getElementById('building1');
            const floorInput1 = document.getElementById('location1');
            buildingInput1.addEventListener('change', () => {
                floorInput1.innerHTML = '';
                const finded = dataBuilding.find((e) => e.id == buildingInput1.value);
                const disableSelect = document.createElement('option')
                disableSelect.setAttribute('value', '');
                disableSelect.setAttribute('selected', 'true');
                disableSelect.setAttribute('disabled', 'true');
                disableSelect.innerText = "-- Pilih Lokasi --";
                const arrSelect = [disableSelect];
                for (let idx = 0; idx < +finded.floor; idx++) {
                    const optionSelect = document.createElement('option')
                    optionSelect.setAttribute('value', `Lantai ${idx+1}`);
                    optionSelect.innerText = `Lantai ${idx+1}`;
                    arrSelect.push(optionSelect);
                }
                arrSelect.forEach(element => {
                    floorInput1.appendChild(element);
                });
            });
        @else
            const buildingInput = document.getElementById('building');
            const floorInput = document.getElementById('location');
            buildingInput.addEventListener('change', () => {
                floorInput.innerHTML = '';
                const finded = dataBuilding.find((e) => e.id == buildingInput.value);
                const disableSelect = document.createElement('option')
                disableSelect.setAttribute('value', '');
                disableSelect.setAttribute('selected', 'true');
                disableSelect.setAttribute('disabled', 'true');
                disableSelect.innerText = "-- Pilih Lokasi --";
                const arrSelect = [disableSelect];
                for (let idx = 0; idx < +finded.floor; idx++) {
                    const optionSelect = document.createElement('option')
                    optionSelect.setAttribute('value', `Lantai ${idx+1}`);
                    optionSelect.innerText = `Lantai ${idx+1}`;
                    arrSelect.push(optionSelect);
                }
                arrSelect.forEach(element => {
                    floorInput.appendChild(element);
                });
            });
        @endif
    </script>
    <!--/ DataTable with Buttons -->
@endsection
