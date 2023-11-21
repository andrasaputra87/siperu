<?php

namespace App\Listeners;

use App\Events\ReservationApproved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateRoomAvailability implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ReservationApproved  $event
     * @return void
     */
    public function handle(ReservationApproved $event)
    {
        $reservation = $event->reservation;
        $room = $reservation->room;

        // Ubah status ketersediaan ruangan menjadi 0 tepat saat reservasi dimulai
        $room->availability = 0;
        $room->save();
    }
}
