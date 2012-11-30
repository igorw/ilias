<?php

namespace Igorw\Ilias\Macro;

use Igorw\Ilias\Environment;

class DefineMacro implements Macro
{
    public function invoke(Environment $env, array $args)
    {
        $name = array_shift($args);

        $env[$name] = $env->evaluate($args);
    }
}
