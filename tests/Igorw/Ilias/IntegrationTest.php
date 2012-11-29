<?php

namespace Igorw\Ilias;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    private $program;

    public function setUp()
    {
        $this->program = new Program(
            new Tokenizer(),
            new SexprParser()
        );
    }

    /** @test */
    public function evaluateValue()
    {
        $env = new Environment();
        $this->assertSame(3, $this->program->evaluate('(+ 1 2)', $env));
    }

    /** @test */
    public function evaluateDefine()
    {
        $env = new Environment();
        $this->program->evaluate('(define foo 42)', $env);
        $this->assertSame(42, $env['foo']);
    }
}
