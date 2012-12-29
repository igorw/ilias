<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class DefMacroOp implements SpecialOp
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $name = $args->car()->getSymbol();
        $macroArgs = $args->cdr()->car();
        $macroBody = $args->cdr()->cdr()->car();
        $env[$name] = new MacroOp($macroArgs, $macroBody);
    }
}
