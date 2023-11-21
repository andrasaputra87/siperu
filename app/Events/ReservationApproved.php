<?php

namespace App\Events;

use App\Models\Room;
use App\Models\RoomReservation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReservationApproved implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reservation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RoomReservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function handle()
    {
        $room = Room::findOrFail($this->reservation->room->id);

        // Ubah status ketersediaan ruangan menjadi 0
        $room->availability = 0;
        $room->save();
    }

}
