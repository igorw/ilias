<?php

namespace functional;

class ReadmeTest extends \PHPUnit_Framework_TestCase
{
    public function provideExamplesFromReadme()
    {
        preg_match_all(
            '(```php(?P<code>.+?)```.+?```(?P<output>.+?)```.+?)s',
            file_get_contents(__DIR__ . '/../../README.md'),
            $matches
        );
        $tests = [];
        foreach ($matches['code'] as $index => $value) {
            $tests[] = [$value, $matches['output'][$index]];
        }
        return $tests;
    }

    /**
     * @test
     * @dataProvider provideExamplesFromReadme
     */
    public function usageSample($code, $output)
    {
        $this->setOutputCallback(function ($output) {
            return trim($output);
        });
        $this->expectOutputString(trim($output));
        $this->assertNull(
            eval($code)
        );
    }

}
