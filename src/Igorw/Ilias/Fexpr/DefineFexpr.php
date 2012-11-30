<?php

namespace Igorw\Ilias\Fexpr;

use Igorw\Ilias\Environment;

class DefineFexpr implements Fexpr
{
    public function invoke(Environment $env, array $args)
    {
        $name = array_shift($args);

        $env[$name] = $env->evaluate($args);
    }
}
