<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Events\PostCreated;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content'
    ];

    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usersThatLike()
    {
        return $this->morphToMany(User::class, 'likeable')->withPivot('id');
    }

    public function usersThatDislike()
    {
       return $this->morphToMany(User::class, 'dislikeable')->withPivot('dislikeable_type'); 
    }

    public function isLiked()
    {
        return $this->usersThatLike()->where('user_id', Auth::user()->id)->exists();
    }

    public function isDisliked()
    {
        return $this->usersThatDislike()->where('user_id', Auth::user()->id)->exists();
    }
}
