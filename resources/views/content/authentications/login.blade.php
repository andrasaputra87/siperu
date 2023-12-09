@extends('layouts/blankLayout')

@section('title', 'Masuk')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              {{-- <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span> --}}
              <img src="{{ asset('assets/img/favicon/upr.png') }}" alt="" class="app-brand-logo demo" width="45px">
              <span class="app-brand-text demo text-body fw-bolder">{{ config('variables.templateName') }}</span>
              {{-- <span class="app-brand-text demo text-body fw-bolder">{{config('variables.templateName')}}</span> --}}
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Selamat Datang di {{config('variables.templateName')}}! 👋</h4>
          <p class="mb-4">Silahkan masuk ke akun anda.</p>

          @if (session()->has('message_success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('message_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>
          @endif

          @if (session()->has('message_error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            {{ session('message_error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>
          @endif

          <form id="formAuthentication" class="mb-3" action="{{url('/')}}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control @error('email') border-danger @enderror" id="email" name="email" placeholder="Masukkan email anda" autofocus required value="{{ old('email') }}">
              @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Kata Sandi</label>
                <a href="{{url('/forgot-password')}}">
                  <small>Lupa Kata Sandi?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                <label class="form-check-label" for="remember-me">
                  Ingat Saya
                </label>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
            </div>
          </form>
          <p class="text-center">
            <span>Daftar Penggunaan Gedung</span>
            <a href="{{url('jadwal')}}">
              <span>KLIK</span>
            </a>
          </p>
          {{-- <p class="text-center">
            <span>Pengguna baru?</span>
            <a href="{{url('register')}}">
              <span>Daftar sekarang</span>
            </a>
          </p>

          <div class="divider my-4">
            <div class="divider-text">atau</div>
          </div> --}}

          <div class="d-flex justify-content-center">
            {{-- <a href="/auth/facebook" class="btn btn-icon btn-label-facebook me-3">
              <i class="tf-icons bx bxl-facebook"></i>
            </a>

            <a href="/auth/google" class="btn btn-icon btn-label-google-plus me-3">
              <i class="tf-icons bx bxl-google"></i>
            </a> --}}

            {{-- <a href="javascript:;" class="btn btn-icon btn-label-twitter">
              <i class="tf-icons bx bxl-twitter"></i>
            </a> --}}
          </div>

        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection
