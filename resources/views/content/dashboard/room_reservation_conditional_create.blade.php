@extends('layouts/contentNavbarLayout')

@section('title', 'Pinjam Ruangan')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/datatables-responsive.css') }}">
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet"
        href="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.css" />
    <style>
        /* Styles for signature plugin v1.2.0. */
        .kbw-signature {
            width: 40%;
            height: 200px;
        }

        #sign canvas {
            width: 100% !important;
            height: auto;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('vendor-script')
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/select2/select2.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js">
    </script>
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/vendor/libs/sweetalert2/sweetalert2.js">
    </script>
    {{-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> --}}
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="http://keith-wood.name/js/jquery.signature.js"></script>
@endsection

@section('page-script')
    <script
        src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template/demo/assets/js/forms-selects.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            var toast = $('#toast');
            toast.toast('show'); // Menampilkan toast

            // Menutup toast secara otomatis setelah 5 detik (5000 ms)
            setTimeout(function() {
                toast.toast('hide');
            }, 2500);
        });

        var dt_basic_table = $('.datatables-basic');
        var dt_basic = dt_basic_table.DataTable({
            ordering: false,
            responsive: true,
            info: false,
            searching: false,
            lengthChange: false,
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
    <script>


        // Dapatkan elemen input tanggal
        const reservationDateInput = document.getElementById('reservation_date');

        // Dapatkan tanggal hari ini
        const today = new Date().toISOString().split('T')[0];

        // Atur nilai minimum tanggal untuk tanggal hari ini
        reservationDateInput.setAttribute('min', today);


        function myFunction() {
            let date = document.getElementById("reservation_date").value;
            let id_room = {{ $room->id }};
            // alert(date);
            $.ajax({
                type:'POST',
                url:'/get_conditional',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{date:date,id_room:id_room},
                success:function(html){
                    // console.log(html.data)
                    if (html.success) {
                        $("#start_time").empty();
                        $("#start_time").append('<option>Pilih Sesi</option>');
                        $.each(html.data, function (key, value) {

                            $("#start_time").append('<option value="' + value[
                                    "id"] + '">' + value["start"].substring(0,5) + ' WIB (' + value["nama"] +
                                ') </option>');
                        });
                    }else{
                        alert(html.data);
                    }
                }
            })
        }
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

    @if ($building->floor>0)  
        <div class="pull-right">
        @for ($i = 1; $i <= $building->floor; $i++)
        <a class="btn btn-primary" href="/all-ruangan-con/{{ $building_id }}/Lantai {{$i}}" role="button">Lantai {{$i}}</a>
        @endfor
    @endif
    <!-- DataTable with Buttons -->
    <div class="row">
        <div class="col-12 col-md-6 col-xl-7 col-xxl-8 mb-3">
            <div class="card">
                <div class="card-body">
                    @if (auth()->user()->role == 'user' &&
                            (!auth()->user()->nim || !auth()->user()->department_id || !auth()->user()->phone_number))
                        <div class="text-center mb-4">
                            <h4 class="address-title text-primary">Isi Data Diri Anda</h4>
                            <p>Oops! sepertinya anda belum melengkapi data diri anda. Isi form dibawah untuk melanjutkan
                                peminjaman.</p>
                        </div>
                        <hr>
                        <form action="/complete_personal_data/{{ auth()->user()->id }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nim">NIM <span class="text-danger fw-bold">*</span></label>
                                    <input type="number" name="nim"
                                        class="form-control @error('nim') invalid @enderror"
                                        value="{{ auth()->user()->nim ?? old('nim') }}">
                                    @error('nim')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone_number">No. Telepon <span class="text-danger fw-bold">*</span></label>
                                    <input type="number" name="phone_number"
                                        class="form-control @error('phone_number') invalid @enderror"
                                        value="{{ auth()->user()->phone_number }}">
                                    @error('phone_number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col mb-3">
                                    <label for="department_id">Jurusan <span class="text-danger fw-bold">*</span></label>
                                    <select name="department_id" id="select2Basic"
                                        class="select2 form-select @error('department_id') invalid @enderror"
                                        data-allow-clear="true">
                                        <option value=""></option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    @else
                        <div class="text-center mb-4">
                            <h4 class="address-title text-primary">{{ $room->name }}</h4>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Data Peminjaman</div>
                        </div>

                        @if ($room->ownership == 'baak')
                            <form action="{{ route('room_reservation_conditional.store') }}" method="POST" class="row g-3">
                                @csrf
                                <input type="hidden" name="baak">
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="reservation_date">Tanggal Pinjam</label>
                                            <input type="date" id="reservation_date" name="reservation_date" onchange="myFunction()"
                                                class="form-control @error('reservation_date') border-danger @enderror"
                                                value="{{ old('reservation_date') }}" />
                                            @error('reservation_date')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-3 custom-col">
                                            <label class="form-label" for="start_time">Waktu Mulai</label>
                                            <select class="form-control" name="start_time" id="start_time">
                                                <option>Pilih Sesi</option>
                                            </select>
                                            @error('start_time')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-3 custom-col">
                                            <label class="form-label" for="end_time">SKS (Per sks di kali 45 menit)</label>
                                            <select class="form-control" name="sks">
                                                <option>Pilih SKS</option>
                                                <option value='2'>2 SKS</option>
                                                <option value='3'>3 SKS</option>
                                                <option value='4'>4 SKS</option>
                                            </select>
                                            @error('sks')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="necessary" class="form-label">Permohonan Keperluan</label>
                                    <textarea name="necessary" id="necessary" rows="5"
                                        class="form-control @error('necessary') border-danger @enderror">{{ old('necessary') }}</textarea>
                                    @error('necessary')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                                
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                    <!-- <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">Cancel</button> -->
                                </div>
                            </form>
                        @else
                            <form action="{{ route('room_reservation.store') }}" method="POST" class="row g-3">
                                @csrf
                                <input type="hidden" name="bm">
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <div class="col-12">
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="organization_name">Nama Fakultas/Organisasi
                                                <span class="text-danger fw-bold">*</span></label>
                                            <input type="text" id="organization_name" name="organization_name"
                                                class="form-control @error('organization_name') border-danger @enderror"
                                                value="{{ old('organization_name') }}"
                                                placeholder="Masukkan nama fakultas/organisasi" />
                                            @error('organization_name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="necessary">Acara/Kegiatan <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="text" id="necessary" name="necessary"
                                                class="form-control @error('necessary') border-danger @enderror"
                                                value="{{ old('necessary') }}" placeholder="Masukkan acara/kegiatan" />
                                            @error('necessary')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="total_participants">Jumlah Peserta <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="number" id="total_participants" name="total_participants"
                                                class="form-control @error('total_participants') border-danger @enderror"
                                                value="{{ old('total_participants') }}"
                                                placeholder="Masukkan jumlah peserta (orang)" />
                                            @error('total_participants')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="reservation_date">Tanggal Pinjam <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="date" id="reservation_date" name="reservation_date"
                                                class="form-control @error('reservation_date') border-danger @enderror"
                                                value="{{ old('reservation_date') }}" />
                                            @error('reservation_date')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="start_time">Waktu Mulai <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="time" id="start_time" name="start_time"
                                                class="form-control @error('start_time') border-danger @enderror"
                                                value="{{ old('start_time') }}" />
                                            @error('start_time')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="end_time">Waktu Selesai <span
                                                    class="text-danger fw-bold">*</span></label>
                                            <input type="time" id="end_time" name="end_time"
                                                class="form-control @error('end_time') border-danger @enderror"
                                                value="{{ old('end_time') }}" />
                                            @error('end_time')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="divider text-center">
                                        <div class="divider-text">Petugas</div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="building_officer">Bangunan</label>
                                            <input type="text" id="building_officer" name="building_officer"
                                                class="form-control @error('building_officer') border-danger @enderror"
                                                value="{{ old('building_officer') }}"
                                                placeholder="Masukkan nama petugas bangunan" />
                                            @error('building_officer')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="security_officer">Keamanan</label>
                                            <input type="text" id="security_officer" name="security_officer"
                                                class="form-control @error('security_officer') border-danger @enderror"
                                                value="{{ old('security_officer') }}"
                                                placeholder="Masukkan nama petugas keamanan" />
                                            @error('security_officer')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="clean_officer">Kebersihan</label>
                                            <input type="text" id="clean_officer" name="clean_officer"
                                                class="form-control @error('clean_officer') border-danger @enderror"
                                                value="{{ old('clean_officer') }}"
                                                placeholder="Masukkan nama petugas kebersihan" />
                                            @error('clean_officer')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="logistic_officer">Logistik</label>
                                            <input type="text" id="logistic_officer" name="logistic_officer"
                                                class="form-control @error('logistic_officer') border-danger @enderror"
                                                value="{{ old('logistic_officer') }}"
                                                placeholder="Masukkan nama petugas logistik" />
                                            @error('logistic_officer')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-lg-6 custom-col">
                                            <label class="form-label" for="etc_officer">Lain-lain</label>
                                            <input type="text" id="etc_officer" name="etc_officer"
                                                class="form-control @error('etc_officer') border-danger @enderror"
                                                value="{{ old('etc_officer') }}"
                                                placeholder="Masukkan nama petugas lainnya" />
                                            @error('etc_officer')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="divider text-center">
                                        <div class="divider-text">Catatan</div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-12 custom-col">
                                            <label class="form-label" for="note">Catatan</label>
                                            <textarea id="note" name="note" class="form-control @error('note') border-danger @enderror" rows="10">{{ old('note') }}</textarea>
                                            @error('note')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Jaminan <span class="text-danger fw-bold">*</span></label>
                                    <div class="row">
                                        <div class="col-md mb-md-0 mb-3">
                                            <div
                                                class="form-check custom-option custom-option-icon @error('guarantee') border-danger @enderror">
                                                <label class="form-check-label custom-option-content" for="radioKTP">
                                                    <span class="custom-option-body">
                                                        <i class="bx bxs-id-card"></i>
                                                        <span class="custom-option-title">KTP</span>
                                                        <small> Kartu Tanda Penduduk </small>
                                                    </span>
                                                    <input name="guarantee" class="form-check-input" type="radio"
                                                        value="ktp" id="radioKTP"
                                                        {{ old('guarantee') == 'ktp' ? 'checked' : '' }} />
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md mb-md-0 mb-3">
                                            <div
                                                class="form-check custom-option custom-option-icon @error('guarantee') border-danger @enderror">
                                                <label class="form-check-label custom-option-content" for="radioKTM">
                                                    <span class="custom-option-body">
                                                        <i class='bx bx-id-card'></i>
                                                        <span class="custom-option-title"> KTM </span>
                                                        <small> Kartu Tanda Mahasiswa </small>
                                                    </span>
                                                    <input name="guarantee" class="form-check-input" type="radio"
                                                        value="ktm" id="radioKTM"
                                                        {{ old('guarantee') == 'ktm' ? 'checked' : '' }} />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('guarantee')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @if (!auth()->user()->signature)
                                        <div class="col-12 mt-3">
                                            <div class="row g-3">
                                                <div class="col-12 custom-col">
                                                    <label class="form-label" for="signature">Tanda Tangan</label>
                                                    <div id="sign"
                                                        class="kbw-signature form-control @error('signature') border-danger @enderror">
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
                                    @endif
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">Cancel</button>
                                </div>
                            </form>
                        @endif
                    @endif

                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-5 col-xxl-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4 class="address-title text-primary">Info Ruangan</h4>
                    </div>
                    <div class="divider">
                        <div class="divider-text">Data Ruangan</div>
                    </div>
                    <img src="{{ asset($room->thumbnail) }}" alt="" class="w-100 rounded">
                    <h5 class="text-truncate mt-4 fw-bold">{{ $room->name }}</h5>
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge bg-label-primary">{{ $room->location }}</span>
                        <span class="badge bg-label-primary">{{ $room->capacity }} Orang</span>
                    </div>
                    <p>{{ $room->description }}</p>
                    <table class="table datatables-basic">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_reservation as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    <img src="{{ asset($item->user->avatar) }}"
                                                        alt="{{ $item->user->name }}" class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="/profile/{{ $item->user->slug }}"
                                                    class="text-body text-truncate">
                                                    <span class="fw-semibold">{{ $item->user->fullname }}</span></a>
                                                <small class="text-muted">{{ $item->user->nim }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ date('H:i', strtotime($item->session->start)) }} &nbsp;-&nbsp;
                                        {{ date('H:i', strtotime($item->end_time)) }}
                                    </td>
                                    <td>
                                        @if ($item->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif ($item->status == 'not approved')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($item->status == 'cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/ DataTable with Buttons -->
@endsection
