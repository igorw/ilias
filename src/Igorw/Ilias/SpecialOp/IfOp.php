<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class IfOp implements SpecialOp
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $predicate = $args->car();
        $trueForm  = $args->cdr()->car();
        $elseForm  = $args->cdr()->cdr()->car();

        $form = ($predicate->evaluate($env)) ? $trueForm : $elseForm;
        return $form ? $form->evaluate($env) : null;
    }
}
