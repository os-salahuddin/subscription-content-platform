<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content'];
    
    public function accessLogs() 
    {
        return $this->hasMany(AccessLog::class);
    }
}
