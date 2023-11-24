<?php

namespace App\GameserverApp\Traits;

trait Socials
{
    public function isTwitchStreamer()
    {
        return ! is_null($this->twitch['username']);
    }

    public function twitchUsername()
    {
        return $this->twitch['username'];
    }

    public function twitchOAuthRedirect()
    {
        if(!isset($this->twitch['oauth_redirect'])) {
            return false;
        }

        return $this->twitch['oauth_redirect'];
    }

    public function isStreaming()
    {
        return $this->twitch['streaming'];
    }

    public function hasDiscordSetup()
    {
        return ! is_null($this->discord['username']);
    }

    public function discordUsername()
    {
        return $this->discord['username'];
    }

    public function discordOAuthRedirect()
    {
        if(!isset($this->discord['oauth_redirect'])) {
            return false;
        }

        return $this->discord['oauth_redirect'];
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