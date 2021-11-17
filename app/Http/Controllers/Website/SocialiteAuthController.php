<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthController extends Controller
{
    /**
     * @param $provider
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        $user = DB::transaction(function () use ($provider) {
            $userSoc = Socialite::driver($provider)->stateless()->user();

            $account = SocialAccount::where([
                ['provider', $provider],
                ['provider_user_id', $userSoc->getId()]
            ])->first();

            if ($account) {
                return $account->user;
            } else {
                $user = User::where('email', $userSoc->getEmail())->first();

                if (!$user) {
                    $user = User::create([
                        'email' => $userSoc->getEmail(),
                        'api_token' => Str::random(80)
                    ]);
                }

                $user->social()->create([
                    'provider_user_id' => $userSoc->getId(),
                    'provider' => $provider
                ]);

                return $user;
            }
        });

        Auth::login($user);
        return redirect()->route('website.profile');
    }
}
