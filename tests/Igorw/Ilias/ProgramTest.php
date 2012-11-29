<?php

namespace Igorw\Ilias;

class ProgramTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function evaluateShouldTokenizeAndParseCode()
    {
        $tokenizer = $this->getMock('Igorw\Ilias\Tokenizer');
        $tokenizer
            ->expects($this->once())
            ->method('tokenize')
            ->with('2')
            ->will($this->returnValue(['2']));

        $parser = $this->getMock('Igorw\Ilias\SexprParser');
        $parser
            ->expects($this->once())
            ->method('parse')
            ->with(['2'])
            ->will($this->returnValue([2]));

        $env = $this->getMock('Igorw\Ilias\Environment');
        $env
            ->expects($this->once())
            ->method('evaluate')
            ->with([2])
            ->will($this->returnValue(2));

        $program = new Program($tokenizer, $parser);
        $this->assertSame(2, $program->evaluate('2', $env));
    }
}
