<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinEvent extends Model
{
    //

    protected $guarded = [];

    public function joins()
{
    return $this->hasMany(JoinEvent::class, 'event_id');
}
}
