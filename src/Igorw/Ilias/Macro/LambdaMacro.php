<?php

namespace Igorw\Ilias\Macro;

use Igorw\Ilias\Environment;

class LambdaMacro implements Macro
{
    private $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function invoke(array $args)
    {
        list($argNames, $body) = $args;

        return function () use ($argNames, $body) {
            $env = clone $this->env;

            $vars = array_combine($argNames, func_get_args());
            foreach ($vars as $name => $value) {
                $env[$name] = $value;
            }

            return $env->evaluate($body);
        };
    }
}
