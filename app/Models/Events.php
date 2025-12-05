<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'time_zone',
        'location',
    ];

    public function participants()
    {
        return $this->hasMany(Participants::class, 'event_id');
    }
}
