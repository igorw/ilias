<?php

namespace Igorw\Ilias;

class Environment implements \ArrayAccess
{
    private $vars = array();

    public function __construct()
    {
        $this->vars['define'] = new DefineMacro($this);
        $this->vars['+'] = 'array_sum';
    }

    public function offsetGet($key)
    {
        return $this->vars[$key];
    }

    public function offsetSet($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function offsetExists($key)
    {
        return isset($this->vars[$key]);
    }

    public function offsetUnset($key)
    {
        unset($this->vars[$key]);
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
            return $this->normalizeValue($sexpr);
        }

        $op = array_shift($sexpr);
        $op = is_array($op) ? $this->evaluateExpr($op) : $op;

        if (!isset($this->vars[$op])) {
            throw new \RuntimeException(sprintf('Tried to invoke non-existent op %s', $op));
        }

        $fn = $this->vars[$op];
        if ($fn instanceof Macro) {
            return $this->evaluateMacro($fn, $sexpr);
        }

        return $this->evaluateOp($fn, $sexpr);
    }

    private function normalizeValue($value)
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && "'" === $value[0]) {
            return substr($value, 1);
        }

        if (is_string($value)) {
            return $this->vars[$value];
        }

        return $value;
    }

    private function evaluateOp($fn, array $args)
    {
        $args = $this->evaluateArgs($args);
        return call_user_func($fn, $args);
    }

    private function evaluateMacro($macro, array $args)
    {
        return $macro->invoke($args);
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
