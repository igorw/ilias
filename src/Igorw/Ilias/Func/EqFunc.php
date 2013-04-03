<?php

namespace Igorw\Ilias\Func;

use Igorw\Ilias\Form\SymbolForm;

class EqFunc
{
    public function __invoke($a, $b)
    {
        return $a === $b;
    }
}
