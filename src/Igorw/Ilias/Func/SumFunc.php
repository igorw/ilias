<?php

namespace Igorw\Ilias\Func;

class SumFunc
{
    public function __invoke()
    {
        return array_sum(func_get_args());
    }
}
