<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Log the Google Avatar URL
        \Log::info('Google Avatar: ' . $googleUser->getAvatar());

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'email_verified_at' => now(),
                'password' => bcrypt(Str::random(24)), // random password
                'profile_photo_path' => $googleUser->getAvatar(),                
            ]
        );

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
