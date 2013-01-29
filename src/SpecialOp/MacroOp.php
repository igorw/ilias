<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\Form;
use Igorw\Ilias\Form\ListForm;

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

        return call_user_func_array($transformFn, $form->toArray());
    }
}
