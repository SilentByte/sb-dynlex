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

use SilentByte\DynLex\DynLexUtils;
use SilentByte\DynLex\DynLexBuilder;

// -------------------------------------------------
// Tokenize words and numbers, ignoring white space.
// -------------------------------------------------

// Define the input string.
$input = "Hello world 8273 this 919 28 is a 12 39 44 string\n"
    . "consisting of 328 words 003 and numbers 283";

$lexer = (new DynLexBuilder())
    // Define the rules for words and numbers.
    ->rule('[a-zA-z]+', 'word')
    ->rule('[0-9]+',    'number')

    // Skip end-of-line characters and white space.
    // As '\n' is more specific than '\s', it must be specified first.
    ->newline('\n')
    ->skip('\s')

    // Build the lexer based on the given ruleset.
    ->build();

$tokens = $lexer->collect($input);
DynLexUtils::dumpTokens($tokens);

?>