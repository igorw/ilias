<?php

namespace Igorw\Ilias;

class WalkerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideExpand
     */
    public function expand($expected, $sexpr, array $macros = [])
    {
        $walker = new Walker();
        $builder = new FormTreeBuilder();

        $env = Environment::standard();
        foreach ($macros as $name => $pair) {
            list($argsSexpr, $bodySexpr) = $pair;
            $args = $builder->parseAst([$argsSexpr])[0];
            $body = $builder->parseAst([$bodySexpr])[0];
            $env[$name] = new SpecialOp\MacroOp($args, $body);
        }

        $form = $builder->parseAst([$sexpr])[0];

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
}
