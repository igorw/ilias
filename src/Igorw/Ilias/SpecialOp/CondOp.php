<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class CondOp implements SpecialOp
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $pairs = $args->toArray();

        foreach ($pairs as $pair) {
            list($predicate, $trueForm) = $pair->toArray();
            if ($predicate->evaluate($env)) {
                return $trueForm->evaluate($env);
            }
        }

        return null;
    }
}
