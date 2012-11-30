<?php

namespace Igorw\Ilias\Macro;

use Igorw\Ilias\Environment;

class IfMacro implements Macro
{
    public function invoke(Environment $env, array $args)
    {
        $args[2] = isset($args[2]) ? $args[2] : null;
        list($condition, $trueForm, $falseForm) = $args;

        $form = ($condition) ? $trueForm : $falseForm;
        return $env->evaluate([$form]);
    }
}
