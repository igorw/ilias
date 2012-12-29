<?php

namespace Igorw\Ilias;

class WalkerTest extends \PHPUnit_Framework_TestCase
{
    private $builder;

    public function setUp()
    {
        $this->builder = new FormTreeBuilder();
    }

    /**
     * @test
     * @dataProvider provideExpand
     */
    public function expand($expected, $sexpr, array $macros = [])
    {
        $walker = new Walker();

        $env = Environment::standard();
        foreach ($macros as $name => $pair) {
            list($argsSexpr, $bodySexpr) = $pair;
            $macroArgs = $this->parseSexpr($argsSexpr);
            $macroBody = $this->parseSexpr($bodySexpr);
            $env[$name] = new SpecialOp\MacroOp($macroArgs, $macroBody);
        }

        $form = $this->parseSexpr($sexpr);

        $expanded = $walker->expand($form, $env);
        $this->assertEquals($expected, $expanded->getAst());
    }

    public function provideExpand()
    {
        return [
            'empty list form' => [
                [],
                [],
            ],
            'simple list form' => [
                ['+', 1, 2],
                ['+', 1, 2],
            ],
            'single level macro' => [
                ['+', 1, 2],
                ['plus', 1, 2],
                [
                    'plus' => [
                        ['a', 'b'],
                        ['list', new Ast\QuotedValue('+'), 'a', 'b'],
                    ],
                ],
            ],
            'two level macro' => [
                ['+', 1, 2],
                ['pl', 1, 2],
                [
                    'plus' => [
                        ['a', 'b'],
                        ['list', new Ast\QuotedValue('+'), 'a', 'b'],
                    ],
                    'pl' => [
                        ['a', 'b'],
                        ['list', new Ast\QuotedValue('plus'), 'a', 'b'],
                    ],
                ],
            ],
            'lambda args evasion in macro' => [
                ['lambda', ['plus', 'minus'], ['plus', 'minus', 1]],
                ['lambda', ['plus', 'minus'], ['plus', 'minus', 1]],
                [
                    'plus' => [
                        ['a', 'b'],
                        ['list', new Ast\QuotedValue('+'), 'a', 'b'],
                    ],
                ],
            ],
            'macro replacement within lambda body' => [
                ['lambda', ['a', 'b'], ['+', 'a', 'b']],
                ['lambda', ['a', 'b'], ['plus', 'a', 'b']],
                [
                    'plus' => [
                        ['a', 'b'],
                        ['list', new Ast\QuotedValue('+'), 'a', 'b'],
                    ],
                ],
            ],
        ];
    }

    private function parseSexpr($sexpr)
    {
        return $this->builder->parseAst([$sexpr])[0];
    }
}
