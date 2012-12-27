<?php

namespace Igorw\Ilias;

class Program
{
    private $lexer;
    private $reader;
    private $builder;
    private $expander;

    public function __construct(Lexer $lexer, Reader $reader, FormTreeBuilder $builder, MacroExpander $expander)
    {
        $this->lexer = $lexer;
        $this->reader = $reader;
        $this->builder = $builder;
        $this->expander = $expander;
    }

    public function evaluate(Environment $env, $code)
    {
        $tokens = $this->lexer->tokenize($code);
        $ast = $this->reader->parse($tokens);
        $forms = $this->builder->parseAst($ast);

        $value = null;
        foreach ($forms as $form) {
            $expanded = $this->expander->expand($form, $env);
            $value = $expanded->evaluate($env);
        }
        return $value;
    }
}
