<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'birthDate',
        'gender',
        'phone',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    ////////////////////////////////////////////Author ORM////////////////////////////////////////
    public function books(){
        return $this->hasMany('App\Models\Book','author_id','id');
    }

    public function related(){
        return $this->hasOne('App\Models\Related','author_id');
    }
    ////////////////////////////////////////////Author ORM////////////////////////////////////////





    ////////////////////////////////////////////Reader ORM////////////////////////////////////////
    public function comments(){
        return $this->hasMany('App\Models\Comment','reader_id','id');
    }

    public function ratings(){
        return $this->hasMany('App\Models\Rating','reader_id','id');
    }
    public function marks(){
        return $this->hasMany('App\Models\Mark','reader_id','id');
    }


    public function library(){
        return $this->hasOne('App\Models\Library','reader_id');
    }
    ////////////////////////////////////////////Reader ORM////////////////////////////////////////





    ////////////////////////////////////////////Admin ORM////////////////////////////////////////
    public function advertisement(){
        return $this->hasMany('App\Models\Advertisement','admin_id');
    }
    ////////////////////////////////////////////Admin ORM////////////////////////////////////////
}
