<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    public function show(){
        $user = user::all();
        return $user;
    }

    public function getRow($where){
        $user = user::where($where);
        return $user;
    }
}
