<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forum;
use App\Models\User;

class Message extends Model
{
    use HasFactory;
    protected $table='messages';

    public function forum(){
        return $this->belongsTo(Forum::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
