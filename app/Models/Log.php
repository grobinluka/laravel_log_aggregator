<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_key_id',
        'project_user_id',
        'severity_level_id',
        'description',
    ];

    public function projectUser(){
        return $this->belongsTo(ProjectUser::class);
    }

    public function severityLevel(){
        return $this->belongsTo(SeverityLevel::class);
    }

    public function apiKey(){
        return $this->belongsTo(ApiKey::class);
    }
}
