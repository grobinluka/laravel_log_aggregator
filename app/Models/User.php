<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'role_id',
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
        'password' => 'hashed',
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function projectsUser(){
        return $this->hasMany(ProjectUser::class);
    }

    public function hasRole($roleName){
        return $this->role()->whereName($roleName)->exists();
    }

    public function setUuidAttribute(){
        $this->attributes['uuid'] = $this->getUniqueUUID();
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->uuid = $user->getUniqueUUID();
        });
    }

    public function getUniqueUUID(){
        do{
            $uuid = Str::uuid();
        } while (User::where('uuid', $uuid)->exists());

        return $uuid;
    }
}
