<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_code',
        'user_id',
        'room_number',
        'category',
        'priority',
        'title',
        'description',
        'status',
        'assigned_to',
        'report',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}