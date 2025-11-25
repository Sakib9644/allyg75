<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyStory extends Model
{
    //

    protected $guarded = [];

      public function story()
    {
        return $this->hasMany(StoryDescrip::class, 'my_stories_id');
    }

      public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset($this->thumbnail) : null;
    }

}
