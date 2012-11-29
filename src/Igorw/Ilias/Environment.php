<?php

namespace Igorw\Ilias;

class Environment
{
    private $parser;

    public function __construct(SexprParser $parser = null)
    {
        $this->parser = $parser ?: new SexprParser();
    }

    public function execute($code)
    {
        if (is_numeric($code)) {
            return (int) $code;
        }

        $ast = $this->parser->parse($code);

        $result = null;

        foreach ($ast as $sexpr) {
            $op = array_shift($sexpr);
            $result = $this->executeOp($op, $sexpr);
        }

        return $result;
    }

    private function executeOp($op, $args)
    {
        switch ($op)
        {
            case '+':
                return array_sum($args);
                break;
        }
    }
}
