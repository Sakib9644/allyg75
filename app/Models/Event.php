<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    protected $table = 'event';
    //

    public function joinedUsers()
{
    return $this->belongsToMany(User::class, 'join_events');
}


}
