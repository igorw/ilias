<?php

namespace Igorw\Ilias\Func;

class MinusFunc
{
    public function __invoke()
    {
        $args = func_get_args();
        $value = array_shift($args);

        foreach ($args as $arg) {
            $value -= $arg;
        }

        return $value;
    }
}
