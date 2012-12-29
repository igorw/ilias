<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class DefMacroOp implements SpecialOp
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $name = $args->nth(0)->getSymbol();
        $macroArgs = $args->nth(1);
        $macroBody = $args->nth(2);
        $env[$name] = new MacroOp($macroArgs, $macroBody);
    }
}
