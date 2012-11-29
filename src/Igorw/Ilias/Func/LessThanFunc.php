<?php

namespace Igorw\Ilias\Func;

class LessThanFunc
{
    public function __invoke($a, $b)
    {
        return $a < $b;
    }
}
