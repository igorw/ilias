<?php

namespace Igorw\Ilias\Func;

class PlusFunc
{
    public function __invoke()
    {
        return array_sum(func_get_args());
    }
}
