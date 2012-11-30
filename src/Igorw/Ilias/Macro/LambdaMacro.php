<?php

namespace Igorw\Ilias\Macro;

use Igorw\Ilias\Environment;

class LambdaMacro implements Macro
{
    public function invoke(Environment $env, array $args)
    {
        $argNames = array_shift($args);
        $body = $args;

        return function () use ($env, $argNames, $body) {
            $subEnv = clone $env;

            $vars = array_combine($argNames, func_get_args());
            foreach ($vars as $name => $value) {
                $subEnv[$name] = $value;
            }

            return $subEnv->evaluate($body);
        };
    }
}
