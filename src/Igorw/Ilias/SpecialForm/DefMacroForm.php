<?php

namespace Igorw\Ilias\SpecialForm;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class DefMacroForm implements SpecialForm
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $name = $args->car()->getSymbol();
        $macroArgs = $args->cdr()->car();
        $macroBody = $args->cdr()->cdr()->car();
        $env[$name] = new MacroForm($macroArgs, $macroBody);
    }
}
