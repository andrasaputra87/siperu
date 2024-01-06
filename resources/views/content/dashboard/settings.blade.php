@extends('layouts/contentNavbarLayout')

@section('title', 'Pengaturan')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.css" />
    <style>
        /* Styles for signature plugin v1.2.0. */
        .kbw-signature {
            width: 100%;
            height: 200px;
        }

        #sign canvas {
            width: 100% !important;
            height: auto;
        }
    </style>
@endsection

@section('vendor-script')
    {{-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> --}}
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="http://keith-wood.name/js/jquery.signature.js"></script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.js">
    </script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/js/forms-selects.js">
    </script>
    <script>
        $(document).ready(function() {
            var toast = $('#toast');
            toast.toast('show'); // Menampilkan toast

            // Menutup toast secara otomatis setelah 5 detik (5000 ms)
            setTimeout(function() {
                toast.toast('hide');
            }, 2500);
        });

        var sign = $('#sign').signature({
            syncField: '#signature',
            syncFormat: 'PNG',
        });

        $('#clear').click(function(e) {
            e.preventDefault();
            sign.signature('clear');
            $('#signature').val('');
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
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Detail Profil</h5>
                <!-- Account -->
                <div class="card-body">
                    <form action="{{ route('settings.update', auth()->user()->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ asset(auth()->user()->avatar) }}" alt="user-avatar" class="d-block rounded"
                                height="100" width="100" id="uploadedAvatar" style="object-fit: cover;" />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Unggah foto baru</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" name="avatar" id="upload" class="account-file-input" hidden
                                        accept="image/png, image/jpeg, image/webp, image/jpg" />
                                </label>
                                <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Diperbolehkan PNG, JPG, JPEG, WEBP. Maksimal ukuran 2MB</p>
                            </div>
                        </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="fullname" class="form-label">Nama Lengkap</label>
                            <input class="form-control" type="text" id="fullname" name="fullname"
                                value="{{ auth()->user()->fullname }}" autofocus />
                            @error('fullname')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input class="form-control" type="email" id="email" name="email"
                                value="{{ auth()->user()->email }}" />
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nim" class="form-label">NIP</label>
                            <input type="number" class="form-control" id="nim" name="nim"
                                value="{{ auth()->user()->nim }}" />
                            @error('nim')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="phone_number">Nomor Telepon</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control"
                                value="{{ auth()->user()->phone_number }}" />
                            @error('phone_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="faculty_id">Fakultas/BAAK</label>
                            <select name="faculty_id" id="faculty_id"
                                class="form-select @error('faculty_id') invalid @enderror">
                                <option value="" selected disabled>-- Pilih Jurusan --</option>
                                @foreach ($faculties as $faculty)
                                    <option value="{{ $faculty->id }}"
                                        {{ $faculty->id == auth()->user()->faculty_id ? 'selected' : '' }}>
                                        {{ $faculty->name }}</option>
                                @endforeach
                            </select>
                            @error('faculty_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="department_id">Jurusan</label>
                            <select name="department_id" id="department_id"
                                class="form-select @error('department_id') invalid @enderror">
                                <option value="" selected disabled>-- Pilih Jurusan --</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}"
                                        {{ $department->id == auth()->user()->department_id ? 'selected' : '' }}>
                                        {{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="dokumen_id">Dokumen</label>
                            <div class="col-sm-12">
                                <div id="file-preview" class="file-preview">
                                    <label for="file-upload" id="file-label" class="btn btn-primary me-2 mb-4">Pilih
                                        File</label>
                                    <input type="file" name="dokumen" id="file-upload" hidden accept=".pdf">
                                </div>
                            </div>
                            <p class="text-muted mb-0">Diperbolehkan File PDF. Maksimal ukuran 2MB</p>
                            @error('dokumen_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="row">
                            @if (!auth()->user()->signature)
                                <div class="mb-3 col-md-6">
                                    <div class="row g-3">
                                        <div class="col-12 custom-col">
                                            <label class="form-label" for="signature">Tanda Tangan</label>
                                            <div id="sign"
                                                class="kbw-signature form-control @error('signature') invalid @enderror">
                                            </div>
                                            <textarea name="signature" id="signature" class="d-none"></textarea>
                                            @error('signature')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                            <button id="clear" class="btn btn-danger btn-sm mt-2">Bersihkan
                                                TTD</button>
                                        </div>
                                    </div>

                                </div>
                            @else
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="signature">Tanda Tangan</label><br>
                                    <img src="{{ asset(auth()->user()->signature) }}"
                                        alt="TTD {{ auth()->user()->fullname }}" style="width: 220px; height: 140px;"
                                        class="border rounded me-3">
                                    <a href="/delete_signature" class="btn btn-danger btn-sm mt-2">Ganti TTD</a>
                                </div>
                            @endif
                            <div class="mb-3 col-md-6">
                                <embed src="{{ asset(auth()->user()->dokumen) }}" type="application/pdf" width="100%"
                                    height="200px" />
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                        <button type="reset" class="btn btn-label-secondary">Batal</button>
                    </div>
                </div>
                </form>
                <!-- /Account -->
            </div>
        </div>
    </div>
@endsection
