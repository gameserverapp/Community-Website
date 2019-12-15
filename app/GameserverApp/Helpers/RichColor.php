<?php

namespace GameserverApp\Helpers;

class RichColor
{
    private $richcolor;

    public function __construct($richcolor)
    {
        $this->richcolor = $richcolor;
    }

    public function getRichColor()
    {
        return $this->richcolor;
    }

    public function getRGBAColor()
    {
        $color = $this->separated();

        return implode(',', [
            $color[0] * 255,
            $color[1] * 255,
            $color[2] * 255,
            $color[3]
        ]);
    }

    public function getColorClass()
    {
        switch( $this->noSpaces() )
        {
            case '1,0,0,1':
                return 'red';

            case '1,1,0,1':
                return 'yellow';

            case '1,0,1,1':
                return 'purple';

            case '0,1,0,1':
                return 'green';

            case '0,0,1,1':
            case '0,1,1,1':
                return 'blue';

            case '1,0.4,0,1':
            case '1,0.75,0.3,1':
                return 'orange';

            default:
                return 'black';
        }
    }

    private function separated()
    {
        return explode(',', $this->noSpaces());
    }

    private function noSpaces()
    {
        return str_replace(' ', '', $this->richcolor);
    }
}