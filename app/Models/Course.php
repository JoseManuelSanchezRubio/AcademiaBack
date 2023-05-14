<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Unit;
use App\Models\Professor;
use App\Models\Announcement;

class Course extends Model
{
    use HasFactory;
    protected $table='courses';

    public function users(){
        return $this->belongsToMany(User::class, 'user_course');
    }

    public function professor(){
        return $this->belongsTo(Professor::class);
    }

    public function units(){
        return $this->hasMany(Unit::class);
    }
    public function announcements(){
        return $this->hasMany(Announcement::class);
    }
}
