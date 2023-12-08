<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <title>Data Peminjaman | SIPERU - Aplikasi Peminjaman Ruangan </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/upr.png') }}" />
    <style>
    body {
      background-image: url('{{ asset('assets/img/backgrounds/UPRbg.jpg') }}');
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-position: center;
      background-size: 100% 100%;
    }

</style>
</head>
<body>
    <div class="container">
<br>
<br>
              <div class="row">
                <div class="col-2">

                  <div class="card" >
                    <img src="{{ asset('assets/img/backgrounds/Logo_Universitas_Palangka_Raya.png') }}" class="card-img-top" alt="logo">
                    <div class="card-body">
                      <h5 class="card-title" style="text-align: center">Data Penjadwalan Peminjaman Ruangan</h5>
                      <p class="card-text"><b><i>Data Per {{ \Illuminate\Support\Carbon::now()->format('Y-m-d')  }}</i></b></p>
                    </div>
                    <ul class="list-group list-group-flush" style="text-align: center">
                      @if ($opened->count() > 0)
                      <li class="list-group-item"><small>Peminjaman Kelas Berlangsung</small>
                        @foreach ($opened as $item)
                          <div class="bg-info text-dark"><marquee class="py-3"> {{ ucwords($item->user->fullname) }} | {{ $item->session->start }} - {{ $item->end_time }} | {{ $item->building_name }} ({{ $item->room->name}}) </marquee></div>  
                        @endforeach
                      </li>
                      @endif
                      @if ($off_day->count() > 0)
                      <li class="list-group-item"><small>Peminjaman Kelas Batak</small>
                        @foreach ($off_day as $item)
                          <div class="p-1 mb-2 bg-info text-dark"><marquee class="py-3"> {{ ucwords($item->user->fullname) }} | {{ $item->session->start }} - {{ $item->end_time }} | {{ $item->building_name }} ({{ $item->room->name}}) </marquee></div>  
                        @endforeach                      
                      </li>   
                      @endif
                      
                    </ul>
                  </div>

                </div>
                  <div class="col-10">
                    <div class="card border-warning mb-3" >
                      <div class="card-body text-primary ">
                      <div id='calendar'></div>
                  </div>

              </div>
        </div>
      </div>
    </div>

    @foreach ($reservations as $event)
      <div class="modal" tabindex="-1" id="calendarModal{{ $event->rr_id }}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Detail Jadwal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <ul class="list-group list-group-flush">
                <li class="list-group-item">Nama: {{ ucwords($event->user->fullname) }}</li>
                <li class="list-group-item">Jurusan: {{ ucwords($event->dapartment_name) }}</li>
                <li class="list-group-item">Tanggal: {{ $event->reservation_date }}</li>
                <li class="list-group-item">Waktu Mulai: {{ $event->session->start }}</li>
                <li class="list-group-item">Waktu Selesai: {{ $event->end_time }}</li>
                <li class="list-group-item">SKS: {{ $event->sks }}</li>
                <li class="list-group-item">Gedung: {{ $event->building_name }}</li>
                <li class="list-group-item">Ruangan: {{ $event->room->name }}</li>
                <li class="list-group-item">Keterangan: {{ $event->necessary }}</li>
                @if ($event->status=='approved')
                  <li class="list-group-item">
                    <p class="text-success bg-dark">Status: Disetujui</p>
                  </li>
                @elseif($event->status=="pending")
                  <li class="list-group-item">
                    <p class="text-white bg-danger">Status: Menunggu Persetujuan</p>
                  </li>
                @elseif($event->status=="opened")
                  <li class="list-group-item">
                    <p class="text-dark bg-info">Status: Kelas Dibuka</p>
                  </li>
                @elseif($event->status=="returned")
                  <li class="list-group-item">
                    <p class="text-white bg-primary">Status: Dikembalikan</p>
                  </li>
                @elseif($event->status=="off-day")
                  <li class="list-group-item">
                    <p class="text-dark bg-warning">Status: Kelas Dibatalkan</p>
                  </li>
                @elseif($event->status=="reschedule")
                  <li class="list-group-item">
                    <p class="text-whtie bg-secondary">Status: Dijadwalkan Ulang</p>
                  </li>
                @endif
              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.10/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          themeSystem: 'bootstrap5',
          headerToolbar: {
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
          },
          events: @json($events),
          eventClick: function(info) {
            console.log(info);
              $('#calendarModal'+info.event.id).modal('show');
              // info.el.style.backgroundColor = info.event.backgroundColor;
            }
        });
        calendar.render();
        calendar.gotoDate('2010-01-01');
      });
      

    </script>
    
</body>
</html>