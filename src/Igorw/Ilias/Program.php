<?php

namespace Igorw\Ilias;

class Program
{
    private $lexer;
    private $reader;
    private $builder;

    public function __construct(Lexer $lexer, Reader $reader, FormGraphBuilder $builder)
    {
        $this->lexer = $lexer;
        $this->reader = $reader;
        $this->builder = $builder;
    }

    public function evaluate(Environment $env, $code)
    {
        $tokens = $this->lexer->tokenize($code);
        $ast = $this->reader->parse($tokens);

        $forms = $this->builder->parse($ast);

        $value = null;
        foreach ($forms as $form) {
            $value = $form->evaluate($env);
        }
        return $value;
    }
}
