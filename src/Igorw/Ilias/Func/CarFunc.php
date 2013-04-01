<?php

namespace Igorw\Ilias\Func;

class CarFunc
{
    public function __invoke(array $list)
    {
        return array_shift($list);
    }
}
