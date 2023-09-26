<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'api_key',
        'project_user_id',
    ];

    public function logs(){
        return $this->hasMany(Logs::class);
    }

    public function projectUser(){
        return $this->belongsTo(ProjectUser::class);
    }
}
