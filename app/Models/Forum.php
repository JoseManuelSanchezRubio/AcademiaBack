<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\Message;

class Forum extends Model
{
    use HasFactory;
    protected $table='forums';

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
}
