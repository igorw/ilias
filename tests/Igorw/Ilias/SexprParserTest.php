<?php

namespace Igorw\Ilias;

class SexprParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideParse
     */
    public function parse($expected, array $tokens)
    {
        $parser = new SexprParser();
        $this->assertEquals($expected, $parser->parse($tokens));
    }

    public function provideParse()
    {
        return [
            'value'                     => [[42], ['42']],
            'func invokation'           => [
                [['+', 1, 2]],
                [
                    '(',
                        '+', ' ', '1', ' ', '2',
                    ')'
                ],
            ],
            'nested func invokation'    => [
                [['+', 1, ['+', 2, 3]]],
                [
                    '(',
                        '+', ' ', '1', ' ',
                        '(',
                            '+', '2', '3',
                        ')',
                    ')',
                ],
            ],
            'quoted string'             => [
                [new QuotedValue('foo')],
                ["'", 'foo'],
            ],
            'quoted list'               => [
                [new QuotedValue(['foo'])],
                ["'", '(', 'foo', ')'],
            ],
            'nested quoted list'        => [
                [new QuotedValue([['foo']])],
                ["'", '(', '(', 'foo', ')', ')'],
            ],
        ];
    }
}
