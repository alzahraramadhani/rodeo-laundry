<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google Auth Error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return redirect()->route('login')->with('error', 'Gagal masuk dengan Google: ' . $e->getMessage());
        }

        if (!$googleUser || !$googleUser->getEmail()) {
            return redirect()->route('login')->with('error', 'Tidak dapat mengambil informasi akun Google.');
        }

        // 1. Check if user already exists by google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        // 2. If not found, check by email and link google_id
        if (!$user) {
            $user = User::where('email', $googleUser->getEmail())->first();
            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
            }
        }

        // 3. If still not found, create a new customer user
        if (!$user) {
            $baseUsername = Str::slug($googleUser->getName() ?? explode('@', $googleUser->getEmail())[0], '_');
            if (empty($baseUsername)) {
                $baseUsername = 'user';
            }
            $baseUsername = substr($baseUsername, 0, 40);

            $username = $baseUsername;
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . '_' . mt_rand(100, 9999);
            }

            $user = User::create([
                'username'          => $username,
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'role'              => 'customer',
                'email_verified_at' => now(),
            ]);
        }

        // 4. Ensure a customer profile exists for this user
        Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name'    => $googleUser->getName() ?? $user->username,
                'email'   => $user->email,
                'phone'   => null,
                'address' => null,
                'city'    => 'Kota Malang',
            ]
        );

        // 5. Log the user in
        Auth::login($user, true);
        request()->session()->regenerate();

        // 6. Redirect based on role
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
