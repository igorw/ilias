<?php

namespace Igorw\Ilias;

class LexerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideTokenize
     */
    public function tokenizeValue($expected, $code)
    {
        $lexer = new Lexer();
        $this->assertSame($expected, $lexer->tokenize($code));
    }

    public function provideTokenize()
    {
        return [
            'empty'                     => [
                [],
                '',
            ],
            'empty list'                => [
                ['(', ')'],
                '()',
            ],
            'value'                     => [
                ['42'],
                '42',
            ],
            'list'                      => [
                ['(', '+', '1', '2', ')'],
                '(+ 1 2)',
            ],
            'nested list'               => [
                ['(', '+', '1', '(', '+', '2', '3', ')', ')'],
                '(+ 1 (+ 2 3))',
            ],
            'quoted string'             => [
                ["'", 'foo'],
                "'foo",
            ],
            'quoted list'               => [
                ["'", '(', '(', 'foo', ')', ')'],
                "'((foo))",
            ],
            'multiple top-level lists'  => [
                ['(', 'foo', ')', '(', 'bar', ')'],
                "(foo) (bar)",
            ],
        ];
    }
}
