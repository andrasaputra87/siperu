@extends('layouts/contentNavbarLayout')

@section('title', 'Data Ruangan')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
<link href="
https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css
" rel="stylesheet">
@endsection

@section('vendor-script')
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js
"></script>
@endsection

@section('page-script')
<script>
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin:10,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                }
            }
        });
    });
</script>
@endsection

@section('content')

<!-- DataTable with Buttons -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <img src="{{ asset($room->thumbnail) }}" alt="" class="w-100 rounded">
                    </div>
                    <div class="col-md-8">
                        <h3 class="text-primary">{{ $room->name }}</h3>
                        <div class="d-flex gap-2 mb-3">
                            {{-- @if ($room->availability == 1)
                                <span class="badge bg-label-success">Tersedia</span>
                            @else
                            <span class="badge bg-label-danger">Tidak Tersedia</span>
                            @endif --}}
                            <span class="badge bg-label-primary">{{ $room->location }}</span>
                            <span class="badge bg-label-primary">{{ $room->capacity }} Orang</span>
                        </div>
                        <p class="text-muted">{{ $room->description }}</p>
                    </div>
                    <div class="col-12 mt-5">
                        <h4>Foto Ruangan</h4>
                        <hr>
                        <div class="owl-carousel">
                            @foreach ($room->roomImages as $image)
                                <div>
                                    <img src="{{ asset($image->filename) }}" alt="" height="350px" class="rounded" style="object-fit: cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</div>
<!--/ DataTable with Buttons -->
@endsection
