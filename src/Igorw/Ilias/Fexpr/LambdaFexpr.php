<?php

namespace Igorw\Ilias\Fexpr;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class LambdaFexpr implements Fexpr
{
    public function apply(Environment $env, ListForm $args)
    {
        $argNames = $args->car();
        $body = $args->cdr();

        return function () use ($env, $argNames, $body) {
            $subEnv = clone $env;

            $vars = array_combine($argNames->getAst(), func_get_args());
            foreach ($vars as $name => $value) {
                $subEnv[$name] = $value;
            }

            $forms = $body->toArray();

            $value = null;
            foreach ($forms as $form) {
                $value = $form->evaluate($subEnv);
            }
            return $value;
        };
    }
}
