@extends('layouts/contentNavbarLayout')

@section('title', 'Tambah Pengguna')

@section('vendor-style')
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
@endsection

@section('vendor-script')
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
@endsection

@section('page-script')
<script>
    $(document).ready(function() {
        var toast = $('#toast');
        toast.toast('show'); // Menampilkan toast

        // Menutup toast secara otomatis setelah 5 detik (5000 ms)
        setTimeout(function() {
        toast.toast('hide');
        }, 2500);
    });

    function myFunction() {
            let faculty_id = document.getElementById("faculty_id").value;
            // alert(date);
            $.ajax({
                type:'POST',
                url:'/get_jurusan',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{faculty_id:faculty_id},
                success:function(html){
                    console.log(html.data)
                    if (html.success) {
                        $("#department_id").empty();
                        $("#department_id").append('<option>Pilih Jurusan</option>');
                        $.each(html.data, function (key, value) {

                            $("#department_id").append('<option value="' + value[
                                    "id"] + '">' + value["name"] +' </option>');
                        });
                    }else{
                        alert(html.data);
                    }
                }
            })
        }

        function tutupJurusan() {
            let role = document.getElementById("role").value;
            if(role=='admin_fakultas' || role=='head_baak'){
                $("#div_jurusan").css('display','none');
                $("#department_id").val("");
            }else{
                $("#div_jurusan").css('display','block');
            }
        }
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
                <h5 class="card-title text-primary">Tambah Pengguna</h5>
                <hr>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="fullname">Nama Lengkap <span class="text-danger fw-bold">*</span></label>
                                <input type="text" id="fullname" name="fullname" class="form-control @error('fullname') border-danger @enderror" value="{{ old('fullname') }}" placeholder="Masukkan nama lengkap"/>
                                @error('fullname')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="email">E-mail <span class="text-danger fw-bold">*</span></label>
                                <input type="text" id="email" name="email" class="form-control @error('email') border-danger @enderror" value="{{ old('email') }}" placeholder="Masukkan E-mail"/>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="nim">NIP</label>
                                <input type="number" id="nim" name="nim" class="form-control @error('nim') border-danger @enderror" value="{{ old('nim') }}" placeholder="Masukkan NIP"/>
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="phone_number">No. Telepon <span class="text-danger fw-bold">*</span></label>
                                <input type="number" id="phone_number" name="phone_number" class="form-control @error('phone_number') border-danger @enderror" value="{{ old('phone_number') }}" placeholder="Masukkan No. Telepon"/>
                                @error('phone_number')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-lg-6 custom-col">
                                <label class="form-label" for="role">Role <span class="text-danger fw-bold">*</span></label>
                                <select name="role" id="role" class="form-select @error('role') border-danger @enderror" onchange="tutupJurusan()">
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pengguna</option>
                                    {{-- <option value="lecturer" {{ old('role') == 'lecturer' ? 'selected' : '' }}>Dosen</option> --}}
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="head_baak" {{ old('role') == 'head_baak' ? 'selected' : '' }}>Kepala BAAK</option>
                                    <option value="staff_baak" {{ old('role') == 'staff_baak' ? 'selected' : '' }}>Staff BAAK</option>
                                    {{-- <option value="head_bm" {{ old('role') == 'head_bm' ? 'selected' : '' }}>Kepala BM</option>
                                    <option value="staff_bm" {{ old('role') == 'staff_bm' ? 'selected' : '' }}>Staff BM</option> --}}
                                    <option value="pengelola_gedung" {{ old('role') == 'pengelola_gedung' ? 'selected' : '' }}>Pengelola Gedung</option>
                                    <option value="admin_fakultas" {{ old('role') == 'admin_fakultas' ? 'selected' : '' }}>Admin Fakultas/BAAK</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 col-lg-6 custom-col" >
                                <label class="form-label" for="faculty_id">Fakultas/BAAK</label>
                                <select name="faculty_id" id="faculty_id" class="form-select" onchange="myFunction()">
                                    <option value="" disabled selected>-- Pilih Fakultas/BAAK --</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>{{ $faculty->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 custom-col" id="div_jurusan" >
                                <label class="form-label" for="department_id">Jurusan</label>
                                <select name="department_id" id="department_id" class="form-select">
                                    <option value="" disabled selected>-- Pilih Jurusan --</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                    @endforeach
                                </select>
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
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--/ DataTable with Buttons -->
@endsection
