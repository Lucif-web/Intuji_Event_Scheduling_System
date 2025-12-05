<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participants extends Model
{
    use HasFactory;
    protected $table = 'participants';

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'rsvp_status',
    ];

    public function event()
    {
        return $this->belongsTo(Events::class, 'event_id');
    }
}
