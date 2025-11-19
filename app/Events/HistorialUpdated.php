<?php

namespace App\Events;

use App\Models\Historial;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HistorialUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $historiales;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        // Load all historial with full relations
        $this->historiales = Historial::with([
            'usuario' => function ($query) {
                $query->with([
                    'role',
                    'formacion.nivelFormacion',
                    'equipos.elementosAdicionales'
                ]);
            },
            'equipo.elementosAdicionales'
        ])->get();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('historial-updates'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'historial.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'historiales' => $this->historiales,
        ];
    }
}