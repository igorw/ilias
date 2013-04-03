<?php

namespace Igorw\Ilias\Func;

class AtomFunc
{
    public function __invoke($value)
    {
        return is_string($value);
    }
}
