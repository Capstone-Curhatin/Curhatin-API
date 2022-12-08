<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function getAll(){
        $doctors = User::with('doctor')->where('role', 1)->get();
        if ($doctors){
            return ResponseFormatter::success($doctors, 'Success get all doctor');
        }else{
            return ResponseFormatter::error('Failed to load doctor');
        }
    }

    public function detail(int $id){
        $doctor = User::with('doctor')->find($id)->where('role', 1)->first();
        if ($doctor){
            return ResponseFormatter::success($doctor, 'Success get all doctor');
        }else{
            return ResponseFormatter::error('Failed to load doctor');
        }
    }
}
