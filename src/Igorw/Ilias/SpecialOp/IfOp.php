<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class IfOp implements SpecialOp
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $predicate = $args->nth(0);
        $trueForm  = $args->nth(1);
        $elseForm  = $args->nth(2);

        $form = ($predicate->evaluate($env)) ? $trueForm : $elseForm;
        return $form ? $form->evaluate($env) : null;
    }
}
