<?php

namespace App;

use App\Helpers\FriendshipStatus;
use App\Models\Articles\Article;
use App\Models\Articles\ImagesArticle;
use App\Models\Comments\Comment;
use App\Models\Follows\Follow;
use App\Models\Likes\Like;
use App\Models\Users\Avatar;
use App\Models\Users\Photos\AlbumPhotos;
use App\Models\Users\SpecificData;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function specificData()
    {
        return $this->hasOne(SpecificData::class, 'user_id');
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class, 'user_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id', 'id');
    }

    public function imagesArticle()
    {
        return $this->hasMany(ImagesArticle::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function albums()
    {
        return $this->hasMany(AlbumPhotos::class, 'user_id');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'sender_id', 'recipient_id')
            ->withPivot('status');
    }

}
