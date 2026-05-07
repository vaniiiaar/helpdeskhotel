<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
