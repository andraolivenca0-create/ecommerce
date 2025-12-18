<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;// 2️⃣ Email sudah terdaftar


use Laravel\Socialite\Two\InvalidStateException;
use GuzzleHttp\Exception\ClientException;
use Exception;
// 2️⃣ Email sudah terdaftar
        

class GoogleController extends Controller
{
    /**
     * Redirect ke Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->scopes(['email', 'profile'])
            ->redirect();
    }

    /**
     * Callback dari Google
     */
    public function callback()
    {
        if (request()->has('error')) {
            return redirect()
                ->route('login')
                ->with('info', 'Login dengan Google dibatalkan.');
        }

        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $user = $this->findOrCreateUser($googleUser);

            // LOGIN USER (remember me)
            Auth::login($user, true);

            // Keamanan session
            session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Berhasil login dengan Google!');

        } catch (InvalidStateException $e) {

            return redirect()
                ->route('login')
                ->with('error', 'Session telah berakhir. Silakan coba lagi.');

        } catch (ClientException $e) {

            logger()->error('Google API Error: ' . $e->getMessage());

            return redirect()
                ->route('login')
                ->with('error', 'Gagal menghubungi Google.');

        } catch (Exception $e) {

    }

    /**
     * Cari atau buat user
     */
    protected function findOrCreateU
            logger()->error('OAuth Error: ' . $e->getMessage());

            return redirect()
                ->route('login')
                ->with('error', 'Login gagal. Silakan coba lagi.');
        }
    }

    /**
     * Cari atau buat user
     */
    protected function findOrCreateUser($googleUser): User
    {
        // 1️⃣ Sudah pernah login Google
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            if ($googleUser->getAvatar()) {
                $user->update([
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
            return $user;
        }

        // 2️⃣ Email sudah terdaftar

    }
}
