<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\LoginNeedsVerification;

class LoginController extends Controller
{
    public function submit(Request $request)
    {

        $request->validate([
            'phone' => 'required|min:10'
        ]);

        $user = User::firstOrCreate([
            'phone' => $request->phone
        ]);

        if (!$user) {
            return response()->json(['message' => 'Cannot procced.'], 401);
        }

        $user->notify(new LoginNeedsVerification());


        return response()->json(['message' => 'Notification message sent.']);
    }
    //

    public function verify(Request $request)
    {

        $request->validate([
            'phone' => 'required|numeric|min:10',
            'login_code' => 'required|numeric|between:111111,999999'
        ]);


        $user = User::where('phone', $request->phone)
            ->where('login_code', $request->login_code)
            ->first();

        if($user){
            $user->update([
                'login_code' => null
            ]);
            return $user->createToken($request->login_code)->plainTextToken;
        }
        
        return response()->json(['message'=>'Invalid verification code'], 401);
    }

}
