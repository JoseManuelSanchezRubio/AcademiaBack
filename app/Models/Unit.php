<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Forum;

class Unit extends Model
{
    use HasFactory;
    protected $table='units';

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function forum(){
        return $this->hasOne(Forum::class);
    }
}
