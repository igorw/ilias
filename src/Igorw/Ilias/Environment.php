<?php

namespace Igorw\Ilias;

class Environment
{
    private $tokenizer;
    private $parser;
    private $vars = array();

    public function __construct(Tokenizer $tokenizer = null, SexprParser $parser = null)
    {
        $this->tokenizer = $tokenizer ?: new Tokenizer();
        $this->parser = $parser ?: new SexprParser();

        $this->vars['+'] = 'array_sum';
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
            $result = $this->executeExpr($sexpr);
        }

        return $result;
    }

    private function executeExpr($sexpr)
    {
        if (!is_array($sexpr)) {
            return $sexpr;
        }

        $op = array_shift($sexpr);
        $args = $this->evaluateArgs($sexpr);
        return $this->executeOp($op, $args);
    }

    private function executeOp($op, array $args)
    {
        return call_user_func($this->vars[$op], $args);
    }

    private function evaluateArgs(array $args)
    {
        return array_map(
            function ($arg) {
                return is_array($arg) ? $this->executeExpr($arg) : $arg;
            },
            $args
        );
    }
}
