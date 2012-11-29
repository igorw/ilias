<?php

namespace Igorw\Ilias\Macro;

use Igorw\Ilias\Environment;

class DefineMacro implements Macro
{
    private $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function invoke(array $args)
    {
        list($name, $value) = $args;

        $this->env[$name] = $this->env->evaluate([$value]);
    }
}
