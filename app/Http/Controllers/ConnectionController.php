<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;

class ConnectionController extends Controller
{
    public function connect(string $type)
    {
        session()->put('current_connection_type', $type);

        return Socialite::driver($type)->redirect();
    }

    public function processConnection()
    {
        $user = Socialite::driver(session()->get('current_connection_type'))->stateless()->user();

        auth()->user()->connections()->updateOrCreate(['type' => session()->get('current_connection_type')], [
            'external_id' => $user->id,
            'type' => session()->get('current_connection_type'),
            'token' => $user->token,
            'refresh_token' => $user->refreshToken,
        ]);

        session()->forget('current_connection_type');

        return redirect(back());
    }
}
