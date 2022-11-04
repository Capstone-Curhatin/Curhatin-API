<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    public function fetch(Request $request){
        return ResponseFormatter::success($request->user(), 'Success');
    }

    public function login(Request $request) {

        try {
            $validate = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => 'required'
            ]);

            if ($validate->fails()){
                return ResponseFormatter::error($validate->errors()->first());
            }

            $user = User::where('email', $request->email)->first();

            if(!$user){
                return ResponseFormatter::error('Email not found');
            }else if(!Hash::check($request->password, $user->password)){
                return ResponseFormatter::error('Invalid password');
            }

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $token = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');

        } catch (Exception $err) {
            return ResponseFormatter::error('Authentication Failed');
        }
    }

    public function register(Request $request) {
        try{
            $validate = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:30'],
                'email' => ['required', 'email', 'max:50', 'unique:users'],
                'phone' => ['required', 'string', 'max:15'],
                'role' => ['required', 'integer', 'max:1'],
                'password' => ['required', 'string', 'min:6', new Password]
            ]);

            if ($validate->fails()){
                return ResponseFormatter::error( $validate->errors()->first());
            }

            $otp = rand(1000, 9999);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'otp' => $otp,
                'password' => Hash::make($request->password)
            ]);

            $mail_details = [
                'subject' => 'Your OTP',
                'body' => 'Your OTP is: ' . $otp
            ];

            Mail::to($request->email)->send(new MailNotify($mail_details));

            return ResponseFormatter::success(null, 'User Registered, Check tour email');

        }catch(Exception $err){
            return ResponseFormatter::error($err);
        }
    }

    public function requestOtp(Request $request) {
        $otp = rand(1000, 9999);
        $user = User::where('email', $request->email)->update(['otp' => $otp]);

        if ($user) {

            $mail_details = [
                'subject' => 'Your OTP',
                'body' => 'Your OTP is: ' . $otp
            ];

            Mail::to($request->email)->send(new MailNotify($mail_details));

            return ResponseFormatter::success(null, 'Your OTP sent successfully, check your email');
        }else{
            return ResponseFormatter::error('Failed request OTP!');
        }
    }

    public function verifyOtp(Request $request) {
        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
        if ($user) {
            return ResponseFormatter::success( null, "Your otp is verified");
        }else{
            return ResponseFormatter::error('Your otp is not verified');
        }
    }
}
