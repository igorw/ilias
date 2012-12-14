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
        $elseForm  = $args->cdr()->cdr()->car();

        $form = ($condition->evaluate($env)) ? $trueForm : $elseForm;
        return $form ? $form->evaluate($env) : null;
    }
}
