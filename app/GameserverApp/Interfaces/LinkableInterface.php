<?php

namespace GameserverApp\Interfaces;

interface LinkableInterface
{
    public function indexRoute();

    public function showRoute();

    public function linkableTemplate($url, $options = []);
}