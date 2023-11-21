<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\RoomReservation;
use Illuminate\Console\Command;

class CheckBookingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check booking status and update room availability';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        // dd($currentDate . ' ' . $currentTime);

        $activeBookings = RoomReservation::where(function($query) use ($currentDate, $currentTime) {
            $query
                  ->where(function($query) use ($currentDate, $currentTime) {
                      $query->where('reservation_date', $currentDate)
                            ->where('start_time', '<=', $currentTime)
                            ->where('end_time', '>=', $currentTime)
                            ->where('status', 'approved')
                            ->whereNull('key_status');
                  });
        })
        ->get();

        foreach ($activeBookings as $booking) {
            $room = Room::find($booking->room_id);

            // Ubah status ruangan menjadi "tidak tersedia" jika belum berubah
            if ($room->availability == '1') {
                $room->availability = '0';
                $room->save();
            }
        }

        // return Command::SUCCESS;
    }
}
