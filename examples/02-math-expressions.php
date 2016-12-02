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

// ----------------------------------------------------------------------------
// Scan a mathematical expression and tokenize integers, floats, and operators.
// ----------------------------------------------------------------------------

// Define the input string.
$input = "((10 + 20) / 2 * 3.14) - (.8 - 5 * 2.72)";

$lexer = (new DynLexBuilder())
    // Define the rules for floats and integers.
    // Note that the rule for float is more specific,
    // which is why it must be specified first.
    ->rule('[0-9]*\.[0-9]+', 'float')
    ->rule('[0-9]+',         'integer')

    // Define rules for operators and parentheses.
    ->rule('[\+\-\*\/]',     'operator')
    ->rule('\(',             'open-paren')
    ->rule('\)',             'close-paren')

    // Skip end-of-line characters and white space.
    ->newline('\n')
    ->skip('\s')

    // Build the lexer based on the given rule set.
    ->build();

$tokens = $lexer->collect($input);
DynLexUtils::dumpTokens($tokens);

?>