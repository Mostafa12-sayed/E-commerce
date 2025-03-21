<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        if ($provider) {

            return Socialite::driver($provider)->redirect();
        }
        abort(404);
    }
    public function Callback($provider)
    {
        try {
            $userSocial  =   Socialite::driver($provider)->stateless()->user();
            $user = User::firstOrCreate(
                ['email' => $userSocial->getEmail()],
                [
                    'name' => $userSocial->getName(),
                    'provider' => $provider,
                    'provider_id' => $userSocial->getId(),
                    'image'         => $userSocial->getAvatar(),
                ]
            );
            Auth::login($user);
            return to_route('home');
        } catch (\Exception $e) {
            flash('Failed to login with  ' . $provider, 'danger');
            return to_route('login');
        }
    }
}
