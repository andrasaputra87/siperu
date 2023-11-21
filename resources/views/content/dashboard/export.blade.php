<table style="border: 1px solid black">
    <thead>
    <tr>
        <th colspan="9" style="font-weight: bold; text-align: center;">LAPORAN PEMINJAMAN SIPERU</th>
    </tr>
    <tr style="border: 1px solid black">
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">No</th>
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">Peminjam</th>
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">NIM</th>
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">Tanggal Pinjam</th>
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">Mulai</th>
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">Selesai</th>
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">Keperluan</th>
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">Status</th>
        <th style="border: 1px solid black; font-weight: bold; text-align: center;">Ruangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reservations as $reservation)
        <tr>
            <td style="border: 1px solid black">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black">{{ $reservation->user->fullname }}</td>
            <td style="border: 1px solid black">{{ $reservation->user->nim }}</td>
            <td style="border: 1px solid black">{{ $reservation->reservation_date }}</td>
            <td style="border: 1px solid black">{{ $reservation->start_time }}</td>
            <td style="border: 1px solid black">{{ $reservation->end_time }}</td>
            <td style="border: 1px solid black">{{ $reservation->necessary }}</td>
            <td style="border: 1px solid black">
                @if ($reservation->status == 'approved')
                    Disetujui
                @elseif($reservation->status =='not approved')
                    Ditolak
                @elseif($reservation->status =='cancelled')
                    Dibatalkan
                @else
                    Pending
                @endif
            </td>
            <td style="border: 1px solid black">{{ $reservation->room->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>