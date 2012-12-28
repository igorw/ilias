<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class DefineOp implements SpecialOp
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $name = $args->car()->getSymbol();
        $env[$name] = $args->cdr()->car()->evaluate($env);
    }
}
