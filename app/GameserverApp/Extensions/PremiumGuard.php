<?php

namespace GameserverApp\Extensions;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Validation\UnauthorizedException;
use GameserverApp\Api\OAuthApi;
use GameserverApp\Models\User;

class PremiumGuard implements Guard
{
    private $cacheUser = null;

    use GuardHelpers;

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return app(OAuthApi::class)->hasAuthCookies() and $this->getUser();
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return !app(OAuthApi::class)->hasAuthCookies() or !$this->getUser();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return $this->getUser();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        if(!isset( $this->getUser()->id )) {
            return null;
        }

        return $this->getUser()->id;
    }

    public function logout()
    {
        app(OAuthApi::class)->logout();
        
        app('request')->session()->flush();

        app('request')->session()->regenerate();

        return redirect('/');
    }

    public function validate(array $credentials = [])
    {
        throw new \Exception('Not implemented');
    }

    public function setUser(Authenticatable $user)
    {
        throw new \Exception('Not implemented');
    }

    private function getUser()
    {
        if(!is_null($this->cacheUser) ) {
            return $this->cacheUser;
        }

        try {
            $this->cacheUser = app(OAuthApi::class)->user();
        } catch (UnauthorizedException $e) {
            $this->logout();
        }

        if($this->cacheUser instanceof User) {
            return $this->cacheUser;
        }

        return null;
    }
}