<?php

namespace Igorw\Ilias;

use Igorw\Ilias\Form\Form;
use Igorw\Ilias\Form\ListForm;

class Walker
{
    public function expand(Form $form, Environment $env)
    {
        if (!$this->isExpandable($form, $env)) {
            return $form;
        }

        if (!$this->isMacroCall($form, $env)) {
            return $this->expandSubLists($form, $env);
        }

        $macro = $this->getMacroForm($form, $env);
        $args = $form->cdr();
        $expanded = $macro->expandOne($args, $env);

        return $this->expand($expanded, $env);
    }

    private function isExpandable(Form $form, Environment $env)
    {
        return $form instanceof ListForm;
    }

    private function isMacroCall(ListForm $form, Environment $env)
    {
        return $form->car() instanceof Form\SymbolForm
            && $form->car()->existsInEnv($env)
            && $form->car()->evaluate($env) instanceof SpecialForm\MacroForm;
    }

    private function getMacroForm(ListForm $form, Environment $env)
    {
        return $form->car()->evaluate($env);
    }

    private function expandSubLists(ListForm $form, Environment $env)
    {
        return new ListForm(array_merge(
            [$form->car()],
            array_map(
                function ($form) use ($env) {
                    return $this->expand($form, $env);
                },
                $form->cdr()->toArray()
            )
        ));
    }
}
