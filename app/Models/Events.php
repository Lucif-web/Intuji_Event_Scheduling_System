<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Events extends Model
{
    use HasFactory, HasApiTokens;
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
