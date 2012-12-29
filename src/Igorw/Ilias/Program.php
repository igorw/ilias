<?php

namespace Igorw\Ilias;

class Program
{
    private $lexer;
    private $reader;
    private $builder;
    private $walker;

    public function __construct(Lexer $lexer, Reader $reader, FormTreeBuilder $builder, Walker $walker)
    {
        $this->lexer = $lexer;
        $this->reader = $reader;
        $this->builder = $builder;
        $this->walker = $walker;
    }

    public function evaluate(Environment $env, $code)
    {
        $tokens = $this->lexer->tokenize($code);
        $ast = $this->reader->parse($tokens);
        $forms = $this->builder->parseAst($ast);

        $value = null;
        foreach ($forms as $form) {
            $expanded = $this->walker->expand($form, $env);
            $value = $expanded->evaluate($env);
        }
        return $value;
    }
}
