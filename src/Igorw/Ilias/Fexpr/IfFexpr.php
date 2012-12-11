<?php

namespace Igorw\Ilias\Fexpr;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class IfFexpr implements Fexpr
{
    public function apply(Environment $env, ListForm $args)
    {
        $condition  = $args->car();
        $trueForm   = $args->cdr()->car();
        $falseForm  = $args->cdr()->cdr()->car();

        $form = ($condition->evaluate($env)) ? $trueForm : $falseForm;
        return $form ? $form->evaluate($env) : null;
    }
}
