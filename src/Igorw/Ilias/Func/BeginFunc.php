<?php

namespace Igorw\Ilias\Func;

class BeginFunc
{
    public function __invoke()
    {
        $args = array_values(func_get_args());
        return end($args);
    }
}
