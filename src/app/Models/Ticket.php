<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TicketTimeline;

final class Ticket extends Model
{
    protected $fillable = [

        'user_id',
        'ticket_code',
        'room_number',
        'category',
        'priority',
        'title',
        'description',
        'status',
        'assigned_to',
        'report',
        'report_photo',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timelines()
    {
        return $this->hasMany(TicketTimeline::class)
            ->latest();
    }
}