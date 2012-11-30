<?php

namespace Igorw\Ilias\Fexpr;

use Igorw\Ilias\Environment;

class LambdaFexpr implements Fexpr
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
