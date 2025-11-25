<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryDescrip extends Model
{
    protected $guarded = [];

    public function story()
    {
        return $this->belongsTo(MyStory::class, 'my_stories_id');
    }

       public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset($this->cover_image) : null;
    }
}
