<?php

namespace Igorw\Ilias\Fexpr;

use Igorw\Ilias\Environment;

class IfFexpr implements Fexpr
{
    public function invoke(Environment $env, array $args)
    {
        $args[2] = isset($args[2]) ? $args[2] : null;
        list($condition, $trueForm, $falseForm) = $args;

        $form = ($env->evaluate([$condition])) ? $trueForm : $falseForm;
        return $env->evaluate([$form]);
    }
}
