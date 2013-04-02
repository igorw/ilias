<?php

namespace Igorw\Ilias;

class FormTreeBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideParseAst
     */
    public function parseAst($expected, $sexpr)
    {
        $builder = new FormTreeBuilder();
        $form = $builder->parseAst([$sexpr]);
        $this->assertEquals([$expected], $form);
    }

    public function provideParseAst()
    {
        return [
            'value'                     => [
                new Form\LiteralForm(2),
                2,
            ],
            'simple expression'         => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\LiteralForm(2),
                ]),
                ['+', 1, 2],
            ],
            'nested expression'         => [
                new Form\ListForm([
                    new Form\SymbolForm('+'),
                    new Form\LiteralForm(1),
                    new Form\ListForm([
                        new Form\SymbolForm('+'),
                        new Form\LiteralForm(2),
                        new Form\LiteralForm(3),
                    ]),
                ]),
                ['+', 1, ['+', 2, 3]],
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
                                new Form\LiteralForm(2),
                            ]),
                            new Form\LiteralForm(5),
                            new Form\LiteralForm(1),
                        ]),
                    ]),
                ]),
                ['+', 1, ['+', 2, ['+', 3, 4, 5, 6, ['+', 6, 4, 3, 2], 5, 1]]],
            ],
            'quoted symbol' => [
                new Form\QuoteForm('foo'),
                new Ast\QuotedValue('foo'),
            ],
            'quoted list' => [
                new Form\QuoteForm(['foo', 'bar', 'baz']),
                new Ast\QuotedValue(['foo', 'bar', 'baz']),
            ],
            'quoted nested list' => [
                new Form\QuoteForm([['a', 'b'], ['c', 'd'], ['e', 'f']]),
                new Ast\QuotedValue([['a', 'b'], ['c', 'd'], ['e', 'f']]),
            ],
        ];
    }
}
