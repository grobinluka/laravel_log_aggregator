<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectUser extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $date = ['deleted_at'];

    protected $fillable = [
        'project_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function logs(){
        return $this->hasMany(Log::class);
    }

    public function apiKeys(){
        return $this->hasMany(ApiKey::class);
    }
}
