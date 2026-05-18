<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketTimeline extends Model
{
    protected $fillable = [

        'ticket_id',
        'activity',

    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}