@extends('layouts/blankLayout')

@section('title', 'Daftar')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection


@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner w-100">

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/register')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
              {{-- <img src="{{ asset('assets/img/favicon/jgu_bunga.png') }}" alt="" class="app-brand-logo demo" width="45px"> --}}
              <span class="app-brand-text demo text-body fw-bolder">{{ config('variables.templateName') }}</span>
              {{-- <span class="app-brand-text demo text-body fw-bolder">{{config('variables.templateName')}}</span> --}}
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Daftar akun disini 🚀</h4>
          <p class="mb-4">Buat peminjaman mu mudah dan menyenangkan!</p>

          <form id="formAuthentication" class="mb-3" action="{{url('/register')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="fullname" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control @error('fullname') border-danger @enderror" id="fullname" name="fullname" placeholder="Masukkan nama lengkap anda" value="{{ old('fullname') }}" required>
              @error('fullname')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control @error('email') border-danger @enderror" id="email" name="email" placeholder="Masukkan email anda" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="nim" class="form-label">NIM</label>
              <input type="number" class="form-control @error('nim') border-danger @enderror" id="nim" name="nim" placeholder="Masukkan NIM anda" value="{{ old('nim') }}" required>
              @error('nim')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="department_id" class="form-label">Jurusan</label>
              <select name="department_id" id="department_id" class="form-select @error('department_id') border-danger @enderror" required>
                <option value="" selected disabled>-- Pilih Jurusan --</option>
                @foreach ($departments as $item)
                    <option value="{{ $item->id }}" {{ $item->id == old('department_id') ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
              </select>
              @error('department_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="phone_number" class="form-label">No. Handphone</label>
              <input type="number" class="form-control @error('phone_number') border-danger @enderror" id="phone_number" name="phone_number" placeholder="Masukkan nomor ponsel anda" value="{{ old('phone_number') }}" required>
              @error('phone_number')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password">Kata Sandi</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') border-danger @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required autocomplete="new-password"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') border-danger @enderror" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required autocomplete="new-password"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
              @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary d-grid w-100">
              Daftar
            </button>
          </form>

          <p class="text-center">
            <span>Sudah memiki akun?</span>
            <a href="{{url('/')}}">
              <span>Kembali ke login</span>
            </a>
          </p>

          <div class="divider my-4">
            <div class="divider-text">atau</div>
          </div>

          <div class="d-flex justify-content-center">
            <a href="/auth/facebook" class="btn btn-icon btn-label-facebook me-3">
              <i class="tf-icons bx bxl-facebook"></i>
            </a>

            <a href="/auth/google" class="btn btn-icon btn-label-google-plus me-3">
              <i class="tf-icons bx bxl-google"></i>
            </a>

            {{-- <a href="javascript:;" class="btn btn-icon btn-label-twitter">
              <i class="tf-icons bx bxl-twitter"></i>
            </a> --}}
          </div>

        </div>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>
</div>
@endsection
