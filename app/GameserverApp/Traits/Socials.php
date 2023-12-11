<?php

namespace App\GameserverApp\Traits;

trait Socials
{

    public function twitchUsername()
    {
        return $this->twitch['username'];
    }

    public function hasDiscordSetup()
    {
        return ! is_null($this->discord['username']);
    }

    public function discordUsername()
    {
        return $this->discord['username'];
    }

    public function hasPatreonSetup()
    {
        return ! is_null($this->patreon['username']);
    }

    public function patreonUsername()
    {
        return $this->patreon['username'];
    }

    public function patreonOAuthRedirect()
    {
        if(!isset($this->patreon['oauth_redirect'])) {
            return false;
        }

        return $this->patreon['oauth_redirect'];
    }
}