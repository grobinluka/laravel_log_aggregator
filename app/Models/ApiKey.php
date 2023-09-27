<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $date = ['deleted_at'];

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
