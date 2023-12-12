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
        if(!isset($this->discord['username'])) {
            return false;
        }

        return ! is_null($this->discord['username']);
    }

    public function discordUsername()
    {
        return $this->discord['username'];
    }
}