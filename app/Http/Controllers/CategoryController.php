<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller{

    public function getAllCategory() {
        $categories = Category::orderBy('name')->get();
        if ($categories){
            return ResponseFormatter::success($categories, 'Get successfully!');
        }else{
            return ResponseFormatter::error('Failed get data!');
        }
    }

}
