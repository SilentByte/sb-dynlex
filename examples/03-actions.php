<?php
////
//// MIT License
////
//// Copyright (c) 2016 SilentByte <https://silentbyte.com/>
////
//// Permission is hereby granted, free of charge, to any person obtaining a copy
//// of this software and associated documentation files (the "Software"), to deal
//// in the Software without restriction, including without limitation the rights
//// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
//// copies of the Software, and to permit persons to whom the Software is
//// furnished to do so, subject to the following conditions:
////
//// The above copyright notice and this permission notice shall be included in all
//// copies or substantial portions of the Software.
////
//// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
//// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
//// SOFTWARE.
////

require_once './../vendor/autoload.php';

use SilentByte\DynLex\DynLexBuilder;
use SilentByte\DynLex\DynLexUtils;

// ---------------------------------------------------
// Count words and numbers in the input using actions.
// ---------------------------------------------------

$words = 0;
$numbers = 0;

// Define the input string.
$input = "hello world 8273 this 919 28 is a 12 39 44 string\n"
    . "consisting of 328 words 003 and numbers 283";

$lexer = (new DynLexBuilder())
    // Define a rule for both words and numbers,
    // incrementing the respective counters.
    ->rule('[a-z]+', 'word', function() use (&$words) { $words++; })
    ->rule('[0-9]+', 'number', function() use (&$numbers) { $numbers++; })

    // Skip and ignore all other character sequences.
    ->skip('.')

    // Build the lexer based on the given rule set.
    ->build();

$tokens = $lexer->collect($input);
DynLexUtils::dumpTokens($tokens);

echo "$words words found.\n";
echo "$numbers numbers found.\n";
