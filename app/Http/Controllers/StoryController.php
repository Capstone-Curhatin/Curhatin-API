<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller {

    public function createStory(Request $request) {

        try {
            $validate = Validator::make($request->all(), [
                'body' => ['required'],
                'is_anonymous' => ['required'],
                'category_id' => ['required'],
            ]);

            if ($validate->fails()){
                return ResponseFormatter::error( $validate->errors()->first());
            }

            $story = new Story;
            $story->body = $request->body;
            $story->category_id = $request->category_id;
            $story->user_id = $request->user()->id;
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
        $stories = Story::with('category', 'user')->orderByDesc('created_at');
        if ($stories){
            return ResponseFormatter::paginate($stories->paginate(20));
        }else{
            return ResponseFormatter::error('Failed get data!');
        }
    }

    public function getStoryByCategory(Request $request){
        $stories = Story::with('category', 'user')->where('category_id', $request->category_id)->orderByDesc('created_at');
        if ($stories){
            return ResponseFormatter::paginate($stories->paginate(20));
        }else{
            return ResponseFormatter::error('Data not found!');
        }
    }

    public function getStoryByUser(Request $request){
        $stories = Story::with('category', 'user')->where('user_id', $request->user()->id)->orderByDesc('created_at');
        if ($stories){
            return ResponseFormatter::paginate($stories->paginate(20));
        }else{
            return ResponseFormatter::error('Data not found!');
        }
    }

    public function deleteStory($id){
        Story::destroy($id);
        return ResponseFormatter::success(null, "Success deleted story");
    }

}
