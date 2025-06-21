<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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

        $given  = $googleUser->user['given_name']  ?? Str::before($googleUser->getName(), ' ');
        $family = $googleUser->user['family_name'] ?? Str::after($googleUser->getName(), ' ');

        // Check if user already exists
        $user = User::where('email', $googleUser->getEmail())->first();

        // Download avatar only for first-time login or if no custom photo
        $avatarFilePath = $user && $user->profile_photo_path && 
                          Storage::disk('public')->exists($user->profile_photo_path)
                          ? $user->profile_photo_path
                          : null;

        if (!$avatarFilePath) {
            // Download latest avatar
            $avatarUrl      = $googleUser->getAvatar();
            $avatarContents = Http::get($avatarUrl)->body();
            $avatarFilePath = 'profile-photos/' . uniqid() . '.jpg';
            Storage::disk('public')->put($avatarFilePath, $avatarContents);
        }

        if (!$user) {
            // First-time login — create new user
            $user = User::create([
                'name'              => $googleUser->getName(),
                'first_name'        => $given,
                'last_name'         => $family,
                'email'             => $googleUser->getEmail(),
                'email_verified_at' => now(),
                'password'          => bcrypt(Str::random(24)),
                'profile_photo_path'=> $avatarFilePath,
            ]);
        } else {
            // Optional: You can update the avatar only, if you want to refresh the photo.
            $user->update([
                'profile_photo_path' => $avatarFilePath,
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
