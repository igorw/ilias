<?php

namespace Igorw\Ilias;

use Igorw\Ilias\Form\Form;
use Igorw\Ilias\Form\SymbolForm;
use Igorw\Ilias\Form\ListForm;

class Walker
{
    public function expand(Environment $env, Form $form)
    {
        if (!$this->isExpandable($env, $form)) {
            return $form;
        }

        if ($this->isLambdaForm($env, $form)) {
            return $this->expandLambdaForm($env, $form);
        }

        if (!$this->isMacroCall($env, $form)) {
            return $this->expandSubLists($env, $form);
        }

        $macro = $this->getMacroOp($env, $form);
        $args = $form->cdr();
        $expanded = $macro->expandOne($env, $args);

        return $this->expand($env, $expanded);
    }

    private function isExpandable(Environment $env, Form $form)
    {
        return $form instanceof ListForm;
    }

    private function isLambdaForm(Environment $env, ListForm $form)
    {
        return $form->nth(0) instanceof SymbolForm
            && $form->nth(0)->existsInEnv($env)
            && $form->nth(0)->evaluate($env) instanceof SpecialOp\LambdaOp;
    }

    private function isMacroCall(Environment $env, ListForm $form)
    {
        return $form->nth(0) instanceof SymbolForm
            && $form->nth(0)->existsInEnv($env)
            && $form->nth(0)->evaluate($env) instanceof SpecialOp\MacroOp;
    }

    private function getMacroOp(Environment $env, ListForm $form)
    {
        return $form->nth(0)->evaluate($env);
    }

    private function expandLambdaForm(Environment $env, ListForm $form)
    {
        $subEnv = clone $env;
        foreach ($form->nth(1)->toArray() as $argName) {
            $subEnv[$argName->getSymbol()] = null;
        }

        return new ListForm(array_merge(
            [$form->nth(0), $form->nth(1)],
            $this->expandList($subEnv, $form->cdr()->cdr())
        ));
    }

    private function expandSubLists(Environment $env, ListForm $form)
    {
        if (!count($form->toArray())) {
            return $form;
        }

        return new ListForm(array_merge(
            [$form->nth(0)],
            $this->expandList($env, $form->cdr())
        ));
    }

    private function expandList(Environment $env, ListForm $form)
    {
        return array_map(
            function ($form) use ($env) {
                return $this->expand($env, $form);
            },
            $form->toArray()
        );
    }
}
