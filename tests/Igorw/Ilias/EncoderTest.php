<?php

namespace Igorw\Ilias;

class EncoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideEncode
     */
    public function encode($expected, array $ast)
    {
        $encoder = new Encoder();
        $this->assertEquals($expected, $encoder->encode($ast));
    }

    public function provideEncode()
    {
        return [
            'empty'                     => ['', []],
            'value'                     => ['42', [42]],
            'func invokation'           => [
                '(+ 1 2)',
                [['+', 1, 2]],
            ],
            'nested func invokation'    => [
                '(+ 1 (+ 2 3))',
                [['+', 1, ['+', 2, 3]]],
            ],
            'quoted string'             => [
                "'foo",
                [new QuotedValue('foo')],
            ],
            'quoted list'               => [
                "'(foo)",
                [new QuotedValue(['foo'])],
            ],
            'nested quoted list'        => [
                "'((foo))",
                [new QuotedValue([['foo']])],
            ],
            'multiple top-level lists'  => [
                "(foo) (bar)",
                [['foo'], ['bar']],
            ],
        ];
    }
}
