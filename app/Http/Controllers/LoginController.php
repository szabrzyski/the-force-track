<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function loginUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|min:1|max:255',
                'password' => 'required|string|min:8|max:255',
            ],
            [
                'email.*' => 'Invalid e-mail address',
                'password.*' => 'Invalid password',
            ]
        );

        if ($validator->stopOnFirstFailure()->fails()) {
            return response()->json($validator->errors(), 427);
        }

        $email = $request->email;
        $password = $request->password;

        if (Auth::attemptWhen(['email' => $email, 'password' => $password], function ($user) {
            return $user->isVerified();
        }, true)) {
            $user = Auth::user();
            $request->session()->regenerate();

            $redirectTo = redirect()->getIntendedUrl() ?? route('issues', [], false);

            return response()->json(['redirectTo' => $redirectTo, 'user' => $user], 200);
        }

        return response()->json('Invalid login data', 420);
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json('Success', 200);
    }
}
