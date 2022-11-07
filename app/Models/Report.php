<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Report extends Model{
    use HasFactory;

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function userReport(){
        return $this->hasOne(User::class, 'user_report_id', 'id');
    }

}
