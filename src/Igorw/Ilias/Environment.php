<?php

namespace Igorw\Ilias;

class Environment
{
    private $tokenizer;
    private $parser;

    public function __construct(Tokenizer $tokenizer = null, SexprParser $parser = null)
    {
        $this->tokenizer = $tokenizer ?: new Tokenizer();
        $this->parser = $parser ?: new SexprParser();
    }

    public function execute($code)
    {
        $tokens = $this->tokenizer->tokenize($code);
        $ast = $this->parser->parse($tokens);

        return $this->executeAst($ast);
    }

    public function executeAst(array $ast)
    {
        $result = null;

        foreach ($ast as $sexpr) {
            if (!is_array($sexpr)) {
                $result = $sexpr;
                continue;
            }

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
