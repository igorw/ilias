<?php

namespace Igorw\Ilias;

class TokenizerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function tokenizeValue()
    {
        $tokenizer = new Tokenizer();
        $this->assertSame(['42'], $tokenizer->tokenize('42'));
    }

    /** @test */
    public function tokenizeList()
    {
        $tokenizer = new Tokenizer();
        $this->assertSame(['(', '+', ' ', '1', ' ', '2', ')'], $tokenizer->tokenize('(+ 1 2)'));
    }

    /** @test */
    public function tokenizeNestedList()
    {
        $tokenizer = new Tokenizer();
        $tokens = ['(', '+', ' ', '1', ' ', '(', '+', ' ', '2', ' ', '3', ')', ')'];
        $this->assertSame($tokens, $tokenizer->tokenize('(+ 1 (+ 2 3))'));
    }
}
