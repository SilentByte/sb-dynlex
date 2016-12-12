<?php

use PHPUnit\Framework\TestCase;
use SilentByte\DynLex\DynLexRule;

class DynLexRuleTest extends TestCase
{
    /**
     * @dataProvider validPatternProvider
     */
    public function testValidPatterns($pattern)
    {
        new DynLexRule($pattern, '', '');
    }

    /**
     * @dataProvider invalidPatternProvider
     * @expectedException InvalidArgumentException
     */
    public function testInvalidPatterns($pattern)
    {
        new DynLexRule($pattern, '', '');
    }

    public function validPatternProvider()
    {
        return array_map(function($e) { return [$e]; }, [
            '[a-zA-z]+',
            '[0-9]+',
            '[0-9]*\.[0-9]+',
            '[\+\-\*\/]',
            '(function|echo|return)',
            '\n'
        ]);
    }

    public function invalidPatternProvider()
    {
        return array_map(function($e) { return [$e]; }, [
            '[a-zA-z',
            '[0-9]+*',
            'function|echo|return)'
        ]);
    }
}

