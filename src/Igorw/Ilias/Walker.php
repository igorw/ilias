<?php

namespace Igorw\Ilias;

use Igorw\Ilias\Form\Form;
use Igorw\Ilias\Form\SymbolForm;
use Igorw\Ilias\Form\ListForm;

class Walker
{
    public function expand(Form $form, Environment $env)
    {
        if (!$this->isExpandable($form, $env)) {
            return $form;
        }

        if ($this->isLambdaForm($form, $env)) {
            return $this->expandLambdaForm($form, $env);
        }

        if (!$this->isMacroCall($form, $env)) {
            return $this->expandSubLists($form, $env);
        }

        $macro = $this->getMacroOp($form, $env);
        $args = $form->cdr();
        $expanded = $macro->expandOne($args, $env);

        return $this->expand($expanded, $env);
    }

    private function isExpandable(Form $form, Environment $env)
    {
        return $form instanceof ListForm;
    }

    private function isLambdaForm(ListForm $form, Environment $env)
    {
        return $form->nth(0) instanceof SymbolForm
            && $form->nth(0)->existsInEnv($env)
            && $form->nth(0)->evaluate($env) instanceof SpecialOp\LambdaOp;
    }

    private function isMacroCall(ListForm $form, Environment $env)
    {
        return $form->nth(0) instanceof SymbolForm
            && $form->nth(0)->existsInEnv($env)
            && $form->nth(0)->evaluate($env) instanceof SpecialOp\MacroOp;
    }

    private function getMacroOp(ListForm $form, Environment $env)
    {
        return $form->nth(0)->evaluate($env);
    }

    private function expandLambdaForm(ListForm $form, Environment $env)
    {
        $subEnv = clone $env;
        foreach ($form->nth(1)->toArray() as $argName) {
            $subEnv[$argName->getSymbol()] = null;
        }

        return new ListForm(array_merge(
            [$form->nth(0), $form->nth(1)],
            $this->expandList($form->cdr()->cdr(), $subEnv)
        ));
    }

    private function expandSubLists(ListForm $form, Environment $env)
    {
        if (!count($form->toArray())) {
            return $form;
        }

        return new ListForm(array_merge(
            [$form->car()],
            $this->expandList($form->cdr(), $env)
        ));
    }

    private function expandList(ListForm $form, Environment $env)
    {
        return array_map(
            function ($form) use ($env) {
                return $this->expand($form, $env);
            },
            $form->toArray()
        );
    }
}
