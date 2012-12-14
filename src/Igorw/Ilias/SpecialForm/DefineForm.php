<?php

namespace Igorw\Ilias\SpecialForm;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class DefineForm implements SpecialForm
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $name = $args->car()->getSymbol();
        $env[$name] = $args->cdr()->car()->evaluate($env);
    }
}
