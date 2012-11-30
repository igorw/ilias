<?php

namespace Igorw\Ilias;

class TokenizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideTokenize
     */
    public function tokenizeValue($expected, $code)
    {
        $tokenizer = new Tokenizer();
        $this->assertSame($expected, $tokenizer->tokenize($code));
    }

    public function provideTokenize()
    {
        return [
            'value'                 => [['42'], '42'],
            'list'                  => [
                ['(', '+', ' ', '1', ' ', '2', ')'],
                '(+ 1 2)',
            ],
            'nested list'           => [
                ['(', '+', ' ', '1', ' ', '(', '+', ' ', '2', ' ', '3', ')', ')'],
                '(+ 1 (+ 2 3))',
            ],
            'quoted string'         => [
                ["'", 'foo'],
                "'foo",
            ],
            'quoted list'           => [
                ["'", '(', '(', 'foo', ')', ')'],
                "'((foo))",
            ],
        ];
    }
}
