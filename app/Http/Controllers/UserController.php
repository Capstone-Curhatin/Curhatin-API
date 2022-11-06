<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use Carbon\Carbon;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    public function fetch(Request $request){
        return ResponseFormatter::success($request->user(), 'Success');
    }

    public function update(Request $request){
        $user = User::find($request->user()->id);

        $image_path = "/images/users/" . $user->picture;
        if (File::exists($image_path)){
            File::delete($image_path);
        }

        if ($request->picture){
            $getImage = $request->picture;
            $imageName = time(). '.' . $getImage->extension();
            $imagePath = public_path(). '/images/users';

            $user->picture = $imageName;
            $getImage->move($imagePath, $imageName);
        }
        $user->update($request->all());

        return ResponseFormatter::success($user, 'User updated');
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

            if ($user->email_verified_at == null){
                return ResponseFormatter::error('Your account must be verification');
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


            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);

            $otp = rand(1000, 9999);
            $mail_details = [
                'subject' => 'Your Curhatin OTP',
                'body' => 'Your OTP is: ' . $otp
            ];

            Mail::to($request->email)->send(new MailNotify($mail_details));
            User::where('email', $request->email)->update(['otp' => $otp]);

            return ResponseFormatter::success(null, 'User Registered, Check tour email');

        }catch(Exception $err){
            return ResponseFormatter::error($err);
        }
    }

    public function userVerification(Request $request){
        try {
            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
            if ($user){
                $user->markEmailAsVerified();
                return ResponseFormatter::success(null, 'Your account is verified');
            }else{
                return ResponseFormatter::error('Failed verification account');
            }
        }catch (Exception $err){
            return ResponseFormatter::error($err);
        }
    }

    public function logout(Request $request) {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function requestOtp(Request $request) {
        try {
            $otp = rand(1000, 9999);
            $user = User::where('email', $request->email)->update(['otp' => $otp]);

            if ($user) {

                $mail_details = [
                    'subject' => 'Your Curhatin OTP',
                    'body' => 'Your OTP is: ' . $otp
                ];

                Mail::to('wahed.blog99@gmail.com')->send(new MailNotify($mail_details));

                return ResponseFormatter::success(null, 'Your OTP sent successfully, check your email');
            }else{
                return ResponseFormatter::error('Failed request OTP!');
            }
        }catch (Exception $err){
            return ResponseFormatter::error($err);
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

    public function newPassword(Request $request){
        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        if ($user){
            return ResponseFormatter::success(null, 'Change password success');
        }else{
            return ResponseFormatter::error('Failed change password!, try again!');
        }
    }
}
