@extends('layouts/contentNavbarLayout')

@section('title', 'Data Gedung')

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



    </div>
    <!-- DataTable with Buttons -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @if ($building_edit)
                        <form action="{{ route('building.update', $building_edit) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col mb-3">
                                    {{-- {{ $building_edit->name }} --}}
                                    <label for="name" class="form-label">Nama Gedung <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') border-danger @enderror"
                                        placeholder="Masukkan nama gedung" value="{{ $building_edit->building_name }}">
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    {{-- {{ $building_edit->name }} --}}
                                    <label for="checkfloor" class="form-label">Apakah Gedung bertingkat? <span
                                            class="text-danger fw-bold">*</span></label>
                                    {{-- <input type="checkbox" name="status" {{ $building_edit->checkfloor==1 ? 'checked': '' }}/> --}}
                                    <input class="form-check-input" type="checkbox" name="checkfloor" id="checkflooredit"
                                        onclick="myFunctionEdit()" value="{{ $building_edit->checkfloor }}"
                                        {{ $building_edit->checkfloor == 0 ? 'checked' : null }} />
                                    @error('checkfloor')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row" id="idlantaiedit"
                                <?= $building_edit->floor > 0 ? '' : "style='display:none;'" ?>>
                                <div class="col mb-3">
                                    {{-- {{ $building_edit->name }} --}}
                                    <label for="name" class="form-label">Jumlah Lantai <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="lantai" id="lantaiedit"
                                        class="form-control @error('lantai') border-danger @enderror"
                                        placeholder="Masukkan banyaknya lantai di gedung"
                                        value="{{ $building_edit->floor }}">
                                    @error('lantai')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label" for="pengelola_id">Pengelola Gedung</label>
                                    <select name="pengelola_id" id="pengelola_id" class="form-select">
                                        <option value="" disabled selected>-- Pilih Pengelola --</option>
                                        @foreach ($pengelola as $peng)
                                            <option value="{{ $peng->id }}"
                                                {{ $building_edit->id_user == $peng->id ? 'selected' : '' }}>
                                                {{ $peng->fullname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <img src="{{ asset($building_edit->thumbnail) }}" alt="{{ $building_edit->building_name }}"
                                class=" rounded mb-3 shadow-sm" style="width: 70%; height: 40%; border: 1px solid #d9dee3;">
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
                        <form action="{{ route('building.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="name" class="form-label">Nama Gedung <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') border-danger @enderror"
                                        placeholder="Masukkan nama gedung" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    {{-- {{ $building_edit->name }} --}}
                                    <label for="checkfloor" class="form-label">Apakah Gedung bertingkat? <span
                                            class="text-danger fw-bold">*</span></label>
                                    {{-- <input type="checkbox" name="status" {{ $building_edit->checkfloor==1 ? 'checked': '' }}/> --}}
                                    <input class="form-check-input" type="checkbox" name="checkfloor" id="checkfloor"
                                        onclick="myFunction()" value="0" />
                                    @error('checkfloor')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row" id="idlantai" style="display:none">
                                <div class="col mb-3">
                                    {{-- {{ $building_edit->name }} --}}
                                    <label for="name" class="form-label">Jumlah Lantai <span
                                            class="text-danger fw-bold">*</span></label>
                                    <input type="text" name="lantai" id="lantai"
                                        class="form-control @error('name') border-danger @enderror"
                                        placeholder="Masukkan banyaknya lantai di gedung" value="0">
                                    @error('lantai')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label" for="pengelola_id">Pengelola Gedung</label>
                                    <select name="pengelola_id" id="pengelola_id" class="form-select">
                                        <option value="" disabled selected>-- Pilih Pengelola --</option>
                                        @foreach ($pengelola as $peng)
                                            <option value="{{ $peng->id }}">
                                                {{ $peng->fullname }}</option>
                                        @endforeach
                                    </select>
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
                                    <th>Jumlah Lantai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($building as $building)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset($building->thumbnail) }}" alt="{{ $building->name }}"
                                                style="width: 70px; height: 70px; object-fit:cover"></td>
                                        <td><b>{{ $building->building_name }}</b></td>
                                        <td>{{ $building->floor }} </td>

                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('building.edit', $building) }}"
                                                    class="btn btn-sm btn-icon item-edit"><i class="bx bxs-edit"></i></a>
                                                <form action="{{ route('building.destroy', $building) }}"
                                                    id="delete-form-{{ $building->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" href=""
                                                        class="btn btn-sm btn-icon tombol-hapus"><i
                                                            class="bx bx-trash"></i></button>
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

<script type="text/javascript">
    function myFunction() {
        var checkBox = document.getElementById("checkfloor");
        var text = document.getElementById("idlantai");

        if (checkBox.checked == true) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
            document.getElementById("lantai").value = "0";
        }
    }

    function myFunctionEdit() {
        var checkBox = document.getElementById("checkflooredit");
        var text = document.getElementById("idlantaiedit");

        if (checkBox.checked == true) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
            // document.getElementById("lantai").value = "0";
        }
    }
</script>
