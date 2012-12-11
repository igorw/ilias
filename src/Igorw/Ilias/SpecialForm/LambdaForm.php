<?php

namespace Igorw\Ilias\SpecialForm;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class LambdaForm implements SpecialForm
{
    public function evaluate(Environment $env, ListForm $args)
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
