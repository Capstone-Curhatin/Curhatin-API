<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller {

    public function createStory(Request $request) {

        try {
            $validate = Validator::make($request->all(), [
                'title' => ['required'],
                'body' => ['required'],
                'is_anonymous' => ['required'],
                'category_id' => ['required'],
                'user_id' => ['required'],
            ]);

            if ($validate->fails()){
                return ResponseFormatter::error( $validate->errors()->first());
            }

            $story = new Story;
            $story->title = $request->title;
            $story->body = $request->body;
            $story->category_id = $request->category_id;
            $story->user_id = $request->user_id;
            $story->is_anonymous = $request->is_anonymous;
            $story->created_at = Carbon::now();
            $story->updated_at = Carbon::now();
            $story->save();

            return ResponseFormatter::success(null, 'Category create success');
        }catch (\Exception $err){
            return ResponseFormatter::error($err);
        }
    }

    public function getAllStory(){
        $stories = Story::with('category', 'user')->get();
        if ($stories){
            return ResponseFormatter::success($stories, 'Success get data');
        }else{
            return ResponseFormatter::error('Failed get data!');
        }
    }

}
