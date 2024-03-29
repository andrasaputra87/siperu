@extends('layouts/contentNavbarLayout')

@section('title', 'Pinjam Ruangan')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    {{-- <style>
    .custom-col {
        padding-right: 5px!important; /* Atur jarak horizontal di sebelah kanan setiap kolom */
        padding-left: 5px!important; /* Atur jarak horizontal di sebelah kiri setiap kolom */
    }
</style> --}}
@endsection

@section('vendor-script')
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js">
    </script>
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

    <!-- DataTable with Buttons -->
    <div class="row">
        @if (!$total_ruang->isEmpty())
            @foreach ($total_ruang as $room)
                <div class="col-12 col-md-6 col-lg-4 col-xxl-3 mb-3">
                    <div class="card overflow-hidden">
                        <img src="{{ asset($room->thumbnail) }}" alt="" class="img-fluid"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="text-truncate">{{ $room->building_name }}
                                <div class="d-flex gap-2 mb-3">
                                    <span class="badge bg-label-primary">Total Ruangan Tersedia : {{ $total_ruang_tersedia }}</span>
                                    <span class="badge bg-label-primary"></span>
                                </div>
                                <div class="d-flex gap-2 mb-3">
                                    <a href="/all-ruangan-con/{{ $room->id }}" class="btn btn-primary d-block">Daftar
                                        Ruangan</a>
                                </div>


                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center p-5">
                        <h2 class="text-primary">Data Gedung Kosong!</h2>
                        <p class="mb-5">Ups! 😥 silahkan hubungi admin untuk menambahkan ruangan.</p>
                        <img src="{{ asset('assets/img/illustrations/page-misc-error-light.png') }}" alt=""
                            class="img-fluid" width="500">
                    </div>
                </div>
            </div>
        @endif

    </div>
    <!--/ DataTable with Buttons -->
@endsection
