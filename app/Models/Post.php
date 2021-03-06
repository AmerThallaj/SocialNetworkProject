<?php

namespace App\Models;

use App\Events\PostDeletedEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['text_body'];
    protected $hidden = ['created_at', 'postable_type'];
    protected $dispatchesEvents = [
        'deleting'=>PostDeletedEvent::class,
    ];

    public function postable()
    {
        return $this->morphTo();
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    public function hashtags()
    {
        return $this->morphToMany(Hashtag::class, 'hashtagable');
        //we can add extra columns for pivot tabel
        //$this->belongsToMany(Hashtag::class)->withPivot('active', 'created_by');
        //the only pivot we have now is post_id,hashtag_id
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function share()
    {
        return $this->belongsToMany(Post::class, 'share_posts', 'source_post_id', 'shared_post_id');
    }
}
