<?php

namespace Igorw\Ilias;

class TokenizerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function parseValue()
    {
        $tokenizer = new Tokenizer();
        $this->assertSame(['42'], $tokenizer->tokenize('42'));
    }
}
