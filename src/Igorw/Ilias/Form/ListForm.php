<?php

namespace Igorw\Ilias\Form;

use Igorw\Ilias\Environment;
use Igorw\Ilias\SpecialForm\SpecialForm;

class ListForm implements Form
{
    private $forms;

    public function __construct(array $forms)
    {
        $this->forms = $forms;
    }

    public function evaluate(Environment $env)
    {
        $func = $this->car() ? $this->car()->evaluate($env) : null;

        if (!$func) {
            throw new \RuntimeException(sprintf('Tried to invoke non-existent function %s', $func));
        }

        if ($func instanceof SpecialForm) {
            return $func->evaluate($env, $this->cdr());
        }

        $args = $this->evaluateArgs($env, $this->cdr());
        return call_user_func_array($func, $args);
    }

    public function getAst()
    {
        return array_map(
            function ($form) {
                return $form->getAst();
            },
            $this->forms
        );
    }

    public function car()
    {
        return isset($this->forms[0]) ? $this->forms[0] : null;
    }

    public function cdr()
    {
        return new static(array_slice($this->forms, 1));
    }

    public function toArray()
    {
        return $this->forms;
    }

    private function evaluateArgs(Environment $env, ListForm $args)
    {
        return array_map(
            function ($arg) use ($env) {
                return $arg->evaluate($env);
            },
            $args->toArray()
        );
    }
}
