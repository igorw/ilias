<?php

namespace Igorw\Ilias\SpecialForm;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class IfForm implements SpecialForm
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $condition  = $args->car();
        $trueForm   = $args->cdr()->car();
        $falseForm  = $args->cdr()->cdr()->car();

        $form = ($condition->evaluate($env)) ? $trueForm : $falseForm;
        return $form ? $form->evaluate($env) : null;
    }
}
