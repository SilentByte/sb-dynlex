<?php

use PHPUnit\Framework\TestCase;

use SilentByte\DynLex\DynLexAction;
use SilentByte\DynLex\DynLexBuilder;

class DynLexLexerTest extends TestCase
{
    public function testCollectedTokens()
    {
        $lexer =(new DynLexBuilder())
            ->rule('[a-zA-z]+', 'word')
            ->rule('[0-9]+',    'number')
            ->skip('\s')
            ->build();

        $input = 'Hello world 8273 this 919 28 is a 12 39 44 string';

        $tokens = array_map(function($t) { return $t->text; },
                            $lexer->collect($input));

        $expected = explode(' ', $input);

        $this->assertEquals($expected, $tokens);
    }

    public function testLexerActions()
    {
        $wordCount = 0;
        $numberCount = 0;

        $lexer =(new DynLexBuilder())
            ->rule('[^\W\d]+', 'word', function() use (&$wordCount) { $wordCount++; })
            ->rule('[0-9]+', 'number', function() use (&$numberCount) { $numberCount++; })
            ->skip('\s')
            ->build();

        $input = 'Hello world 8273 this 919 28 is a 12 39 44 55 string';
        $lexer->scan($input);

        $this->assertEquals(6, $wordCount);
        $this->assertEquals(7, $numberCount);
    }

    public function testScanCallback()
    {
        $lexer =(new DynLexBuilder())
            ->rule('a+', 'a')
            ->rule('0+', '0')
            ->skip('.')
            ->build();

        $letterSequenceCount = 0;
        $digitSequenceCount = 0;

        $input = 'aaaa 00 aa 0000 aaaa aa aaaa 0000';
        $lexer->scan($input, function($token)
            use (&$letterSequenceCount, &$digitSequenceCount) {
                if($token->tag === null) {
                    return;
                }

                if($token->tag === 'a') {
                    $letterSequenceCount ++;
                }
                else if($token->tag === '0') {
                    $digitSequenceCount++;
                }
                else {
                    throw new \Exception("Unknown tag '{$token->tag}'.");
                }
        });

        $this->assertEquals(5, $letterSequenceCount);
        $this->assertEquals(3, $digitSequenceCount);
    }

    public function testTokenRejection()
    {
        $airplaneCount = 0;
        $planeCount = 0;

        $lexer = (new DynLexBuilder())
            ->rule('airplane', 'airplane', function() use (&$airplaneCount) { $airplaneCount++; return DynlexAction::REJECT; })
            ->rule('plane',    'plane',    function() use (&$planeCount)    { $planeCount++;    return DynlexAction::REJECT; })
            ->skip('.')
            ->build();

        $input = 'airplane plane plane airplane plane airplane plane airplane plane';
        $tokens = $lexer->collect($input);

        $this->assertEquals(4, $airplaneCount);
        $this->assertEquals(9, $planeCount);
        $this->assertEquals(0, count($tokens));
    }

    /**
     * @expectedException UnexpectedValueException
     */
    public function testInputMatchingNoRules()
    {
        $lexer = (new DynLexBuilder())
            ->rule('a', 'a')
            ->build();

        $input = 'aaab';
        $lexer->scan($input);
    }
}

