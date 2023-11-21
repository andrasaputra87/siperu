@extends('layouts/blankLayout')

@section('title', 'Forgot Password Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Forgot Password -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
              {{-- <img src="{{ asset('assets/img/favicon/jgu_bunga.png') }}" alt="" class="app-brand-logo demo" width="45px"> --}}
              <span class="app-brand-text demo text-body fw-bolder">{{ config('variables.templateName') }}</span>
            </a>
          </div>
          <!-- /Logo -->

          <h4 class="mb-2">Lupa Kata Sandi? 🔒</h4>
          <p class="mb-4">Masukkan email anda dan kami akan memberikan instruksi untuk mengembalikan kata sandi anda.</p>
          @if ($errors->any())
              <div class="alert alert-danger alert-dismissible">
                    @foreach ($errors->all() as $error)
                          {{ $error }}
                    @endforeach
              </div>
          @endif
          @if(session()->has('status'))
              <div class="alert alert-success alert-dismissible">
                  {{ session()->get('status') }}
              </div>
          @endif
          <form class="mb-3" action="/forgot-password" method="POST">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email kamu" autofocus>
            </div>
            <button class="btn btn-primary d-grid w-100">Kirim Atur Ulang Tautan</button>
          </form>
          <div class="text-center">
            <a href="{{url('/')}}" class="d-flex align-items-center justify-content-center">
              <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
              Kembali ke login
            </a>
          </div>
        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>
@endsection
