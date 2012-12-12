<?php

namespace Igorw\Ilias;

class FormGraphBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideParseAst
     */
    public function parseAst($expected, $sexpr)
    {
        $builder = new FormGraphBuilder();
        $form = $builder->parseAst([$sexpr]);
        $this->assertEquals([$expected], $form);
    }

    public function provideParseAst()
    {
        return [
            'value'                     => [
                new Form\LiteralForm(2),
                2
            ],
            'simple expression'         => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2)
                ]),
                ['+', 1, 2]
            ],
            'nested expression'         => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\ListForm([
                        new Form\SymbolForm('+'),
                        new Form\LiteralForm(2),
                        new Form\LiteralForm(3)
                    ])
                ]),
                ['+', 1, ['+', 2, 3]]
            ],
            'deeply nested expression'  => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\ListForm([
                        new Form\SymbolForm('+'),
                        new Form\LiteralForm(2),
                        new Form\ListForm([
                            new Form\SymbolForm('+'),
                            new Form\LiteralForm(3),
                            new Form\LiteralForm(4),
                            new Form\LiteralForm(5),
                            new Form\LiteralForm(6),
                            new Form\ListForm([
                                new Form\SymbolForm('+'),
                                new Form\LiteralForm(6),
                                new Form\LiteralForm(4),
                                new Form\LiteralForm(3),
                                new Form\LiteralForm(2)
                            ]),
                            new Form\LiteralForm(5),
                            new Form\LiteralForm(1)
                        ]),
                    ])
                ]),
                ['+', 1, ['+', 2, ['+', 3, 4, 5, 6, ['+', 6, 4, 3, 2], 5, 1]]],
            ],
        ];
    }
}
