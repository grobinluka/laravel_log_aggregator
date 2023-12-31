<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeverityLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
    ];

    public function logs(){
        return $this->hasMany(Log::class);
    }
}
