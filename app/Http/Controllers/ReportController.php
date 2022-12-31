<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller {

    public function sendReport(Request $request){
        try {
            $validate = Validator::make($request->all(), [
                'user_report_id' => ['required'],
                'report_type' => ['required'],
                'description' => ['required'],
            ]);

            if ($validate->fails()){
                return ResponseFormatter::error($validate->errors()->first());
            }

            $report = new Report;
            $report->user_id = $request->user()->id;
            $report->user_report_id = $request->user_report_id;
            $report->report_type = $request->report_type;
            $report->description = $request->description;
            $report->story_id = $request->story_id;
            $report->chat_message = $request->chat_message;
            $report->save();

            return ResponseFormatter::success(null, 'Thank you for telling admin, we will follow up soon');
        }catch (\Exception $err){
            return ResponseFormatter::error($err);
        }
    }

}
