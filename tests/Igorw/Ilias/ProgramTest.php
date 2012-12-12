<?php

namespace Igorw\Ilias;

class ProgramTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function evaluateShouldTokenizeAndParseCode()
    {
        $lexer = $this->getMock('Igorw\Ilias\Lexer');
        $lexer
            ->expects($this->once())
            ->method('tokenize')
            ->with('2')
            ->will($this->returnValue(['2']));

        $reader = $this->getMock('Igorw\Ilias\Reader');
        $reader
            ->expects($this->once())
            ->method('parse')
            ->with(['2'])
            ->will($this->returnValue([2]));

        $builder = $this->getMock('Igorw\Ilias\FormGraphBuilder');
        $builder
            ->expects($this->once())
            ->method('parse')
            ->with([2])
            ->will($this->returnValue([new Form\LiteralForm(2)]));

        $env = $this->getMock('Igorw\Ilias\Environment');

        $program = new Program($lexer, $reader, $builder);
        $this->assertSame(2, $program->evaluate($env, '2'));
    }
}
