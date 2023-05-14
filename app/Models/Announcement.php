<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Professor;
use App\Models\Course;

class Announcement extends Model
{
    use HasFactory;
    protected $table='announcements';

    public function professor(){
        return $this->belongsTo(Professor::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
}
