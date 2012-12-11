<?php

namespace Igorw\Ilias\Fexpr;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class DefineFexpr implements Fexpr
{
    public function apply(Environment $env, ListForm $args)
    {
        $name = $args->car()->getAst();
        $env[$name] = $args->cdr()->car()->evaluate($env);
    }
}
