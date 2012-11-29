<?php

namespace Igorw\Ilias;

class SexprParserTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parseValue()
    {
        $parser = new SexprParser();
        $this->assertSame([42], $parser->parse(['42']));
    }

    /** @test */
    public function parseArithmeticExpression()
    {
        $parser = new SexprParser();
        $this->assertSame([['+', 1, 2]], $parser->parse([
            '(',
                '+', ' ', '1', ' ', '2',
            ')'
        ]));
    }

    /** @test */
    public function parseNestedArithmeticExpression()
    {
        $parser = new SexprParser();
        $this->assertSame([['+', 1, ['+', 2, 3]]], $parser->parse([
            '(',
                '+', ' ', '1', ' ',
                '(',
                    '+', '2', '3',
                ')',
            ')',
        ]));
    }

    /** @test */
    public function parseQuotedString()
    {
        $parser = new SexprParser();
        $this->assertEquals([new QuotedValue('foo')], $parser->parse(["'", 'foo']));
    }

    /** @test */
    public function parseQuotedList()
    {
        $parser = new SexprParser();
        $this->assertEquals([new QuotedValue(['foo'])], $parser->parse(["'", '(', 'foo', ')']));
    }

    /** @test */
    public function parseNestedQuotedList()
    {
        $parser = new SexprParser();
        $this->assertEquals([new QuotedValue([['foo']])], $parser->parse(["'", '(', '(', 'foo', ')', ')']));
    }
}
