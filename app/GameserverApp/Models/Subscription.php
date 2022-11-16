<?php

namespace GameserverApp\Models;

use GameserverApp\Interfaces\LinkableInterface;
use GameserverApp\Traits\Linkable;

class Subscription extends Model
{

    public function id()
    {
        return $this->id;
    }

    public function currency()
    {
        return $this->currency;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function expired()
    {
        return !is_null($this->expires_at);
    }

    public function requiresCharacter()
    {
        return $this->requires_character;
    }

    public function hasCharacter()
    {
        return $this->character instanceof Character;
    }

    public function relatableUrl()
    {
        return $this->relatable_url;
    }

    public function relatableName()
    {
        return $this->relatable_name;
    }

    public function availableCharacters()
    {
        if(!isset($this->available_characters)) {
            return [];
        }

        return $this->available_characters;
    }

    public function gateway()
    {
        return $this->gateway;
    }

    public function isPatreon()
    {
        return $this->gateway() == 'Patreon';
    }
}