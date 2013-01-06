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

        $expanded = $walker->expand($env, $form);
        $this->assertEquals($expected, $expanded->getAst());
    }

    public function provideExpand()
    {
        $macros['plus'] = [
            ['a', 'b'],
            ['list', new Ast\QuotedValue('+'), 'a', 'b'],
        ];

        return [
            'empty list form' => [
                [],
                [],
            ],
            'literal form' => [
                42,
                42,
            ],
            'simple list form' => [
                ['+', 1, 2],
                ['+', 1, 2],
            ],
            'single level macro' => [
                ['+', 1, 2],
                ['plus', 1, 2],
                [
                    'plus' => $macros['plus'],
                ],
            ],
            'two level macro' => [
                ['+', 1, 2],
                ['pl', 1, 2],
                [
                    'plus' => $macros['plus'],
                    'pl' => [
                        ['a', 'b'],
                        ['list', new Ast\QuotedValue('plus'), 'a', 'b'],
                    ],
                ],
            ],
            'nested list form macro' => [
                ['+', 1, ['+', 2, 3]],
                ['plus', 1, ['plus', 2, 3]],
                [
                    'plus' => $macros['plus'],
                ],
            ],
            'lambda args evasion in macro' => [
                ['lambda', ['plus', 'a', 'b'], ['plus', 'a', 'b']],
                ['lambda', ['plus', 'a', 'b'], ['plus', 'a', 'b']],
                [
                    'plus' => $macros['plus'],
                ],
            ],
            'macro replacement within lambda body' => [
                ['lambda', ['a', 'b'], ['+', 'a', 'b']],
                ['lambda', ['a', 'b'], ['plus', 'a', 'b']],
                [
                    'plus' => $macros['plus'],
                ],
            ],
        ];
    }

    private function parseSexpr($sexpr)
    {
        return $this->builder->parseAst([$sexpr])[0];
    }
}
