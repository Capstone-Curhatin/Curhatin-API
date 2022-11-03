<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {

    public function login(Request $request) {

        try {
            $validate = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => 'required'
            ]);

            if ($validate->fails()){
                return ResponseFormatter::error(null, $validate->errors()->all());
            }

            $user = User::where('email', $request->email)->first();

            if(!$user){
                return ResponseFormatter::error( null, 'Email not found');
            }else if(!Hash::check($request->password, $user->password)){
                return ResponseFormatter::error(null, 'Invalid password');
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
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $err,
            ], 'Authentication Failed');
        }

//        try {
//            $validate = Validator::make($request->all(), [
//               'email' => ['required', 'email'],
//               'password' => ['required', 'password']
//            ]);
//
//            if ($validate->fails()) {
//                return ResponseFormatter::error(null, $validate->errors()->all());
//            }
//
//
//            return ResponseFormatter::success("oke", "masok");
//
////            $credentials = request(['email', 'password']);
////            if(!Auth::attempt($credentials)){
////                return ResponseFormatter::error(null, 'Login Failed');
////            }
////
////            $user = User::where('email', $request->email)->first();
////            if (!Hash::check($request->password, $user->password)) {
////                throw new \Exception('Invalid Credentials');
////            }
////
////            $token = $user->createToken('authToken')->plainTextToken;
////            return ResponseFormatter::success([
////                'access_token' => $token,
////                'token_type' => 'Bearer',
////                'user' => $user
////            ], 'Authenticated');
//        }catch (\Exception $err) {
//            return ResponseFormatter::error(null, 'Authentication Failed');
//        }
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
                return ResponseFormatter::error(null, $validate->errors()->all());
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'password' => Hash::make($request->password)
            ]);

            return ResponseFormatter::success([], 'User Registered');

        }catch(Exception $err){
            return ResponseFormatter::error(null, $err);
        }
    }

}
