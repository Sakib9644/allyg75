<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $table = 'event';
    //

    public function joinedEvents()
    {
        return $this->belongsToMany(Event::class, 'join_events');
    }
}
