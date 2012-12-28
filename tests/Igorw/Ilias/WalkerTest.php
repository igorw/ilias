<?php

namespace Igorw\Ilias;

class WalkerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideExpand
     */
    public function expand($expected, $form, array $vars = [])
    {
        $walker = new Walker();

        $env = Environment::standard();
        foreach ($vars as $name => $value) {
            $env[$name] = $value;
        }

        $this->assertEquals($expected, $walker->expand($form, $env));
    }

    public function provideExpand()
    {
        return [
            'empty list form' => [
                new Form\ListForm([]),
                new Form\ListForm([]),
            ],
            'simple list form' => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2),
                ]),
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2),
                ]),
            ],
            'single level macro' => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2),
                ]),
                new Form\ListForm([
                    new Form\SymbolForm('plus'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2),
                ]),
                [
                    'plus' => new SpecialOp\MacroOp(
                        new Form\ListForm([
                            new Form\SymbolForm('a'),
                            new Form\SymbolForm('b'),
                        ]),
                        new Form\ListForm([
                            new Form\SymbolForm('list'),
                            new Form\QuoteForm(new Form\SymbolForm('+')),
                            new Form\SymbolForm('a'),
                            new Form\SymbolForm('b'),
                        ])
                    ),
                ]
            ],
            'two level macro' => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2),
                ]),
                new Form\ListForm([
                    new Form\SymbolForm('pl'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2),
                ]),
                [
                    'plus' => new SpecialOp\MacroOp(
                        new Form\ListForm([
                            new Form\SymbolForm('a'),
                            new Form\SymbolForm('b'),
                        ]),
                        new Form\ListForm([
                            new Form\SymbolForm('list'),
                            new Form\QuoteForm(new Form\SymbolForm('+')),
                            new Form\SymbolForm('a'),
                            new Form\SymbolForm('b'),
                        ])
                    ),
                    'pl' => new SpecialOp\MacroOp(
                        new Form\ListForm([
                            new Form\SymbolForm('a'),
                            new Form\SymbolForm('b'),
                        ]),
                        new Form\ListForm([
                            new Form\SymbolForm('list'),
                            new Form\QuoteForm(new Form\SymbolForm('plus')),
                            new Form\SymbolForm('a'),
                            new Form\SymbolForm('b'),
                        ])
                    ),
                ]
            ],
            'lambda evasion in macro' => [
                new Form\ListForm([
                    new Form\SymbolForm('lambda'),
                    new Form\ListForm([
                        new Form\SymbolForm('plus'),
                        new Form\SymbolForm('minus'),
                    ]),
                    new Form\ListForm([
                        new Form\SymbolForm('plus'),
                        new Form\SymbolForm('minus'),
                        new Form\LiteralForm(1),
                    ]),
                ]),
                new Form\ListForm([
                    new Form\SymbolForm('lambda'),
                    new Form\ListForm([
                        new Form\SymbolForm('plus'),
                        new Form\SymbolForm('minus'),
                    ]),
                    new Form\ListForm([
                        new Form\SymbolForm('plus'),
                        new Form\SymbolForm('minus'),
                        new Form\LiteralForm(1),
                    ]),
                ]),
                [
                    'plus' => new SpecialOp\MacroOp(
                        new Form\ListForm([
                            new Form\SymbolForm('a'),
                            new Form\SymbolForm('b'),
                        ]),
                        new Form\ListForm([
                            new Form\SymbolForm('list'),
                            new Form\QuoteForm(new Form\SymbolForm('+')),
                            new Form\SymbolForm('a'),
                            new Form\SymbolForm('b'),
                        ])
                    ),
                ]
            ],
        ];
    }
}
