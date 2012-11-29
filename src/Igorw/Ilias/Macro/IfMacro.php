<?php

namespace Igorw\Ilias\Macro;

use Igorw\Ilias\Environment;

class IfMacro implements Macro
{
    private $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function invoke(array $args)
    {
        $args[2] = isset($args[2]) ? $args[2] : null;
        list($condition, $trueForm, $falseForm) = $args;

        $form = ($condition) ? $trueForm : $falseForm;
        return $this->env->evaluate([$form]);
    }
}
