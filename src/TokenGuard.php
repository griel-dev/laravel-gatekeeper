<?php

namespace MobileStock\Gatekeeper;

use Illuminate\Contracts\Auth\UserProvider as AuthUserProvider;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class TokenGuard extends \Illuminate\Auth\TokenGuard
{
    public function __construct(
        ?AuthUserProvider $provider,
        Request $request,
        $inputKey = 'id',
        $storageKey = 'id',
        $hash = false
    ) {
        $this->hash = $hash;
        $this->request = $request;
        $this->provider = $provider;
        $this->inputKey = $inputKey;
        $this->storageKey = $storageKey;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $accessToken = $this->request->header('access-token');

        try {
            $user = Socialite::driver('users')->userFromToken($accessToken);
        } catch (\Throwable) {
        }

        if (!empty($user) && !empty($this->provider)) {
            $user = $this->provider->retrieveByCredentials([
                $this->storageKey => $user->id,
            ]);
        }

        return $this->user = $user;
    }
}
