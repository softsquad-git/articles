<?php

namespace App;

use App\Models\Articles\Article;
use App\Models\Articles\ImagesArticle;
use App\Models\Users\Avatar;
use App\Models\Users\SpecificData;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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

}
