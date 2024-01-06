<?php

namespace App\Exports;

use App\Models\RoomReservation;
use App\Models\Faculty;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class BAAKExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithEvents, WithCustomStartCell, WithTitle
{
    use Exportable;
    /**
    * @return \Illuminate\Contracts\View\View
    */
    public function collection()
    {
        return RoomReservation::with(['user', 'room'])
        ->whereHas('room', function ($query) {
            $query->leftjoin('buildings','buildings.id','building_id')
            ->leftJoin('users','users.id','id_user')->where('users.faculty_id', auth()->user()->faculty_id);
        })
        ->get();
    }

    public function map($reservation): array
    {
        return [
            $reservation->id,
            $reservation->user->fullname,
            $reservation->user->nim,
            $reservation->reservation_date,
            $reservation->session->start,
            $reservation->end_time,
            $reservation->necessary,
            $reservation->status,
            $reservation->room->name,
            $reservation->room->building->building_name,
            Faculty::rightJoin('users','users.faculty_id','faculties.id')
            ->where('users.id',$reservation->room->building->id_user)
            ->first('faculties.name as name')->name
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Peminjam',
            'NIP',
            'Tanggal',
            'Waktu Mulai',
            'Waktu Selesai',
            'Keperluan',
            'Status',
            'Ruangan',
            'Gedung',
            'Kepemilikan Fakultas/BAAK'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getStyle('A2:K2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Mengatur border pada seluruh data
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A2:K' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function title(): string
    {
        return 'Semua';
    }

}
