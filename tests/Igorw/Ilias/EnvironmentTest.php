<?php

namespace Igorw\Ilias;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function constructorShouldSetVar()
    {
        $env = new Environment(['foo' => 'bar']);
        $this->assertSame('bar', $env['foo']);
    }

    /** @test */
    public function offsetSetShouldSetVar()
    {
        $env = new Environment();
        $env['foo'] = 'bar';
        $this->assertSame('bar', $env['foo']);
    }

    /** @test */
    public function offsetExistsShouldCheckVarExistence()
    {
        $env = new Environment();
        $this->assertFalse(isset($env['foo']));
        $env['foo'] = 'bar';
        $this->assertTrue(isset($env['foo']));
    }

    /** @test */
    public function offsetUnsetShouldUnsetVar()
    {
        $env = new Environment();
        $env['foo'] = 'bar';
        unset($env['foo']);
        $this->assertFalse(isset($env['foo']));
    }
}
