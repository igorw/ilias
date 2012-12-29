<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class DefineOp implements SpecialOp
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $name = $args->nth(0)->getSymbol();
        $env[$name] = $args->nth(1)->evaluate($env);
    }
}
