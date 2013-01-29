<?php

namespace Igorw\Ilias\Func;

class GreaterThanFunc
{
    public function __invoke($a, $b)
    {
        return $a > $b;
    }
}
