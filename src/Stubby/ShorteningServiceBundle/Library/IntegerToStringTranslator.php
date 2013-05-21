<?php

namespace Stubby\ShorteningServiceBundle\Library;

class IntegerToStringTranslator
{
    private $allowedChars;

    public function __construct($allowedChars = "0a1b2c3d4e5f6g7h8i9jklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
    {
        $this->allowedChars = $allowedChars;
    }

    public function encode($integer)
    {
        $out    = null;
        $length = strlen($this->allowedChars);

        while($integer > $length - 1)
        {
            $out = $this->allowedChars[fmod($integer, $length)] . $out;
            $integer = floor( $integer / $length );
        }
        return $this->allowedChars[$integer] . $out;
    }

    public function decode($string)
    {
        $length = strlen($this->allowedChars);
        $size   = strlen($string) - 1;
        $string = str_split($string);
        $out    = strpos($this->allowedChars, array_pop($string));

        foreach($string as $i => $char)
        {
            $out += strpos($this->allowedChars, $char) * pow($length, $size - $i);
        }
        return $out;
    }
}
