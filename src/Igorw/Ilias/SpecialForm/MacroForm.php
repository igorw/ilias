<?php

namespace Igorw\Ilias\SpecialForm;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\Form;
use Igorw\Ilias\Form\ListForm;

class MacroForm implements SpecialForm
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
        $expanded = $this->expandOne($args, $env);

        return $expanded->evaluate($env);
    }

    private function expandOne(Form $form, Environment $env)
    {
        $transformFormArgs = new ListForm([
            $this->macroArgs,
            $this->macroBody,
        ]);
        $transformForm = new LambdaForm();

        $transformFn = $transformForm->evaluate($env, $transformFormArgs);

        return call_user_func_array($transformFn, $form->toArray());
    }
}
