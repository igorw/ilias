<?php

namespace Igorw\Ilias\Func;

use Igorw\Ilias\Form\SymbolForm;

class EqFunc
{
    public function __invoke($a, $b)
    {
        return (is_object($a) || is_object($b)) ? $a == $b : $a === $b;
    }
}
