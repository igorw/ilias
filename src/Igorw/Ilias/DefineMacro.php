<?php

namespace Igorw\Ilias;

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

        $this->env[$name] = $value;
    }
}
