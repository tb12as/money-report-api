<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::query()
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Incorrect username or password'], 401);
        }

        if (Hash::check($request->password, $user->password)) {
            $apiKey = base64_encode(Str::random(30));

            User::query()
                ->where('username', $request->username)
                ->update(['api_token' => $apiKey]);

            return $this->success(data: [
                'api_token' => enc($apiKey),
            ]);
        }

        return response()->json(['message' => 'Incorrect username or password'], 401);
    }
}
