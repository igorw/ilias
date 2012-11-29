<?php

namespace Igorw\Ilias;

class SexprParserTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parseArithmeticExpression()
    {
        $parser = new SexprParser();
        $this->assertSame([['+', 1, 2]], $parser->parse('(+ 1 2)'));
    }

    /** @test */
    public function parseNestedArithmeticExpression()
    {
        $parser = new SexprParser();
        $this->assertSame([['+', 1, ['+', 2, 3]]], $parser->parse('(+ 1 (+ 2 3))'));
    }
}
