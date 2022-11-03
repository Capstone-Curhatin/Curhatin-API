<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller {

    public function login(Request $request) {
        try {
            $validate = Validator::make($request->all(), [
               'email' => ['required', 'email'],
               'password' => ['required', 'password']
            ]);

            if ($validate->fails()) {
                return ResponseFormatter::error([
                    $validate->errors()
                ], 'Authentication Failed');
            }

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized',
                ], 'Login Failed');
            }

            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $token = $user->creatToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        }catch (\Exception $err) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $err,
            ], 'Authentication Failed');
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
            return ResponseFormatter::error([],$err);
        }
    }

}
