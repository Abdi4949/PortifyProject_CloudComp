<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                $user = User::where('email', $googleUser->getEmail())->first();
                
                if ($user) {
                    $user->update(['google_id' => $googleUser->getId()]);
                } else {
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => Hash::make('password_acak_123'), 
                        'role' => 'user', 
                    ]);
                }
            }

            Auth::login($user);

            return redirect()->intended('dashboard'); 

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Google Gagal: ' . $e->getMessage());
        }
    }
}