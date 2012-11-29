<?php

namespace Igorw\Ilias;

class Environment
{
    private $vars = array();

    public function __construct()
    {
        $this->vars['+'] = 'array_sum';
    }

    public function evaluate(array $ast)
    {
        $result = null;

        foreach ($ast as $sexpr) {
            $result = $this->evaluateExpr($sexpr);
        }

        return $result;
    }

    private function evaluateExpr($sexpr)
    {
        if (!is_array($sexpr)) {
            return $sexpr;
        }

        $op = array_shift($sexpr);
        $args = $this->evaluateArgs($sexpr);
        return $this->evaluateOp($op, $args);
    }

    private function evaluateOp($op, array $args)
    {
        return call_user_func($this->vars[$op], $args);
    }

    private function evaluateArgs(array $args)
    {
        return array_map(
            function ($arg) {
                return is_array($arg) ? $this->evaluateExpr($arg) : $arg;
            },
            $args
        );
    }
}
