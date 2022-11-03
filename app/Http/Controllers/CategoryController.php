<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller{

    public function getAllCategory() {
        $categories = Category::all();
        if ($categories){
            return ResponseFormatter::success($categories, 'Get successfully!');
        }else{
            return ResponseFormatter::error(null, 'Failed get data!');
        }
    }

}
