<?php

namespace Igorw\Ilias\SpecialForm;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

class LambdaForm implements SpecialForm
{
    public function evaluate(Environment $env, ListForm $args)
    {
        $symbols = $args->car()->toArray();
        $argNames = $this->getMappedSymbols($symbols);

        $bodyForms = $args->cdr()->toArray();

        return function () use ($env, $argNames, $bodyForms) {
            $subEnv = clone $env;

            $vars = array_combine($argNames, func_get_args());
            foreach ($vars as $name => $value) {
                $subEnv[$name] = $value;
            }

            $value = null;
            foreach ($bodyForms as $form) {
                $value = $form->evaluate($subEnv);
            }
            return $value;
        };
    }

    private function getMappedSymbols(array $symbols)
    {
        return array_map(
            function ($symbol) {
                return $symbol->getSymbol();
            },
            $symbols
        );
    }
}
