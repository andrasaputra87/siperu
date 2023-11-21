@extends('layouts/contentNavbarLayout')

@section('title', 'Data Ruangan')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
<style>
    /* 1.14 Image Preview */
.image-preview, #callback-preview {
  width: 250px;
  height: 250px;
  border: 2px dashed #ddd;
  border-radius: 3px;
  position: relative;
  overflow: hidden;
  background-color: #ffffff;
  color: #ecf0f1;
}

.image-preview input, #callback-preview input {
  line-height: 200px;
  font-size: 200px;
  position: absolute;
  opacity: 0;
  z-index: 10;
}

.image-preview label, #callback-preview label {
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
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
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
        }).then((result)  => {
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
        input_field: "#image-upload",   // Default: .image-upload
        preview_box: "#image-preview",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "Pilih File",   // Default: Choose File
        label_selected: "Ubah File",  // Default: Change File
        no_label: false,                // Default: false
        success_callback: null          // Default: null
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

 <!-- Timeline Advanced-->
 <div class="row">
 <div class="col-12">
    <div class="card">
      <div class="card-body">
        <ul class="timeline timeline-dashed mt-3">
          @if ($reservations->isEmpty())
          <div class="text-center">
            <h2 class="text-primary">Riwayat Peminjaman Kosong!</h2>
            <p class="mb-5">Ayo, manfaatkan fasilitas yang kami sediakan untuk kegiatan Anda.</p>
            <img src="{{ asset('assets/img/illustrations/page-misc-error-light.png') }}" alt="" class="img-fluid" width="500">
          </div>
          @else
          @foreach ($reservations as $reservation)
          <li class="timeline-item timeline-item-{{ $reservation->status == 'approved' ? 'success' : ($reservation->status == 'pending' ? 'warning' : ($reservation->status == 'cancelled' ? 'primary' : 'danger'))  }} mb-4">
            <span class="timeline-indicator timeline-indicator-{{ $reservation->status == 'approved' ? 'success' : ($reservation->status == 'pending' ? 'warning' : ($reservation->status == 'cancelled' ? 'primary' : 'danger'))  }}">
              <i class="bx bx-{{ $reservation->status == 'approved' ? 'check-circle' : ($reservation->status == 'pending' ? 'time-five' : 'x-circle')  }}"></i>
            </span>
            <div class="timeline-event">
              <div class="timeline-header">
                <h6 class="mb-0">
                    @if ($reservation->status == "approved")
                        Peminjaman Disetujui
                    @elseif ($reservation->status == "pending")
                        Menunggu Konfirmasi
                    @elseif ($reservation->status == "cancelled")
                        Peminjaman Dibatalkan
                    @else
                        Peminjaman Ditolak
                    @endif
                </h6>
                <small class="text-muted">{{ $reservation->reservation_date }}</small>
              </div>
              <p>
                @if ($reservation->status == "approved")
                    Peminjaman Anda telah disetujui oleh pihak SIPERU.
                @elseif ($reservation->status == "pending")
                    Tunggu konfirmasi dari pihak SIPERU.
                @elseif ($reservation->status == "cancelled")
                    Anda telah membatalkan peminjaman ini.
                @else
                    Peminjaman Anda ditolak oleh pihak SIPERU.
                @endif
              </p>
              <hr />
              <div class="d-flex justify-content-between flex-wrap gap-2">
                <div class="d-flex flex-wrap">
                  <div class="avatar me-3">
                    <img src="{{ asset($reservation->room->thumbnail) }}" alt="Avatar" class="rounded" style="object-fit: cover;"/>
                  </div>
                  <div>
                    <p class="mb-0">{{ $reservation->room->name }}</p>
                    <small class="text-muted">{{ $reservation->room->location }} | {{ $reservation->room->capacity }} Orang</small>
                  </div>
                </div>
              </div>
            </div>
          </li>  
          @endforeach
          <li class="timeline-end-indicator">
            <i class="bx bx-check-circle"></i>
          </li>
          @endif
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /Timeline Advanced-->
@endsection
