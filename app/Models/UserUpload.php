<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\User;

class UserUpload extends Model
{
    use HasFactory;
    protected $table='user_uploads';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
