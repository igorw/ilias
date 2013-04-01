<?php

namespace Igorw\Ilias\Func;

class CdrFunc
{
    public function __invoke(array $list)
    {
        array_shift($list);
        return $list;
    }
}
