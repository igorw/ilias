<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\FormTreeBuilder;
use Igorw\Ilias\Form\Form;
use Igorw\Ilias\Form\ListForm;
use Igorw\Ilias\Form\SymbolForm;

class MacroOp implements SpecialOp
{
    private $macroArgs;
    private $macroBody;

    public function __construct(ListForm $macroArgs, ListForm $macroBody)
    {
        $this->macroArgs = $macroArgs;
        $this->macroBody = $macroBody;
    }

    public function evaluate(Environment $env, ListForm $args)
    {
        $expanded = $this->expandOne($env, $args);

        return $expanded->evaluate($env);
    }

    public function expandOne(Environment $env, Form $form)
    {
        $transformForm = new LambdaOp();
        $transformFormArgs = new ListForm([
            $this->macroArgs,
            $this->macroBody,
        ]);

        $transformFn = $transformForm->evaluate($env, $transformFormArgs);

        $rawBody = call_user_func_array($transformFn, $form->toArray());
        return $this->wrapSymbols($rawBody);
    }
    private function wrapSymbols(ListForm $rawBody)
    {
        $wrappedBody = array_map(
            function ($form) {
                if ($form instanceof ListForm) {
                    return $this->wrapSymbols($form);
                }

                if (is_string($form)) {
                    return new SymbolForm($form);
                }

                if (is_numeric($form)) {
                    return new SymbolForm($form);
                }

                return $form;
            },
            $rawBody->toArray()
        );

        return new ListForm($wrappedBody);
    }
}
