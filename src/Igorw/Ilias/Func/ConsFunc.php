<?php

namespace Igorw\Ilias\Func;

class ConsFunc
{
    public function __invoke($value, array $list)
    {
        array_unshift($list, $value);
        return $list;
    }
}
