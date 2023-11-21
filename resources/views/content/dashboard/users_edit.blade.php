@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Pengguna')

@section('vendor-style')
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
@endsection

@section('vendor-script')
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endsection

@section('page-script')
<script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
<script>
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
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title text-primary">Ubah Data Pengguna</h5>
                <hr>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ asset($user->avatar) }}" alt="user-avatar" class="d-block rounded" height="100" width="100"  id="uploadedAvatar" style="object-fit: cover;" />
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Unggah foto baru</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" name="avatar" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg, image/webp, image/jpg" />
                          </label>
                          <button type="button" class="btn btn-label-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>
              
                          <p class="text-muted mb-0">Diperbolehkan PNG, JPG, JPEG, WEBP. Maksimal ukuran 2MB</p>
                        </div>
                      </div>
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="fullname">Nama Lengkap <span class="text-danger fw-bold">*</span></label>
                                <input type="text" id="fullname" name="fullname" class="form-control @error('fullname') border-danger @enderror" value="{{ old('fullname', $user->fullname) }}" placeholder="Masukkan nama lengkap"/>
                                @error('fullname')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="email">E-mail <span class="text-danger fw-bold">*</span></label>
                                <input type="text" id="email" name="email" class="form-control @error('email') border-danger @enderror" value="{{ old('email', $user->email) }}" placeholder="Masukkan E-mail"/>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="nim">NIM / NIP</label>
                                <input type="number" id="nim" name="nim" class="form-control @error('nim') border-danger @enderror" value="{{ old('nim', $user->nim) }}" placeholder="Masukkan NIM"/>
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="phone_number">No. Telepon <span class="text-danger fw-bold">*</span></label>
                                <input type="number" id="phone_number" name="phone_number" class="form-control @error('phone_number') border-danger @enderror" value="{{ old('phone_number', $user->phone_number) }}" placeholder="Masukkan No. Telepon"/>
                                @error('phone_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="department_id">Jurusan</label>
                                <select name="department_id" id="department_id" class="form-select">
                                    <option value="" disabled selected>-- Pilih Jurusan --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="role">Role <span class="text-danger fw-bold">*</span></label>
                                <select name="role" id="role" class="form-select @error('role') border-danger @enderror">
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Pengguna</option>
                                    <option value="lecturer" {{ old('role', $user->role) == 'lecturer' ? 'selected' : '' }}>Dosen</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="head_baak" {{ old('role', $user->role) == 'head_baak' ? 'selected' : '' }}>Kepala BAAK</option>
                                    <option value="staff_baak" {{ old('role', $user->role) == 'staff_baak' ? 'selected' : '' }}>Staff BAAK</option>
                                    <option value="head_bm" {{ old('role', $user->role) == 'head_bm' ? 'selected' : '' }}>Kepala BM</option>
                                    <option value="staff_bm" {{ old('role', $user->role) == 'staff_bm' ? 'selected' : '' }}>Staff BM</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="password">Kata Sandi <span class="text-danger fw-bold">*</span></label>
                                <input type="password" id="password" name="password" class="form-control @error('password') border-danger @enderror" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi <span class="text-danger fw-bold">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password') border-danger @enderror" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"/>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-sm-1">Submit</button>
                        <a href="/users" class="btn btn-label-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ DataTable with Buttons -->
@endsection
