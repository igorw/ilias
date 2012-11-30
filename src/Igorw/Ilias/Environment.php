<?php

namespace Igorw\Ilias;

class Environment implements \ArrayAccess
{
    private $vars;

    public function __construct(array $vars = array())
    {
        $this->vars = $vars;
    }

    public function offsetGet($key)
    {
        return isset($this->vars[$key]) ? $this->vars[$key] : null;
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

        $funcName = array_shift($sexpr);
        $funcName = is_array($funcName) ? $this->evaluateExpr($funcName) : $funcName;

        if (!isset($this->vars[$funcName])) {
            throw new \RuntimeException(sprintf('Tried to invoke non-existent function %s', $funcName));
        }

        $func = $this->vars[$funcName];
        if ($func instanceof Fexpr\Fexpr) {
            return $this->evaluateFexpr($func, $sexpr);
        }

        return $this->evaluateFuncCall($func, $sexpr);
    }

    private function normalizeValue($value)
    {
        if ($value instanceof QuotedValue) {
            return $value->getValue();
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_string($value)) {
            return $this->vars[$value];
        }

        return $value;
    }

    private function evaluateFuncCall($func, array $args)
    {
        $args = $this->evaluateArgs($args);
        return call_user_func_array($func, $args);
    }

    private function evaluateFexpr($fexpr, array $args)
    {
        return $fexpr->invoke($this, $args);
    }

    private function evaluateArgs(array $args)
    {
        return array_map(
            function ($arg) {
                return $this->evaluateExpr($arg);
            },
            $args
        );
    }

    public static function standard()
    {
        return new static([
            'define'    => new Fexpr\DefineFexpr(),
            'lambda'    => new Fexpr\LambdaFexpr(),
            'if'        => new Fexpr\IfFexpr(),

            '+'         => new Func\PlusFunc(),
            '-'         => new Func\MinusFunc(),
            '>'         => new Func\GreaterThanFunc(),
            '<'         => new Func\LessThanFunc(),
        ]);
    }
}
