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

use SilentByte\DynLex\DynLexAction;
use SilentByte\DynLex\DynLexBuilder;
use SilentByte\DynLex\DynLexUtils;

// ------------------------------------------------------------------------
// This example demonstrates the usage of REJECT within lexer actions with
// the intention of counting the words 'airplane' and 'plane' individually,
// i.e. because the word 'plane' is contained within the word 'airplane',
// both counters (airplane and plane) will be incremented.
// ------------------------------------------------------------------------

$airplane = 0;
$plane = 0;

// Define the input string.
$input = 'airplane plane plane airplane plane airplane plane airplane plane';

$lexer = (new DynLexBuilder())
    // Define a rule for both words 'airplane' and 'plane',
    // incrementing the respective counters.
    ->rule('airplane', 'airplane', function() use (&$airplane) { $airplane++; return DynlexAction::REJECT; })
    ->rule('plane',    'plane',    function() use (&$plane)    { $plane++;    return DynlexAction::REJECT; })

    // Skip and ignore all other character sequences.
    ->skip('.')

    // Build the lexer based on the given rule set.
    ->build();

$lexer->scan($input);

// There are 4 occurrences of the word 'airplane' and 5 occurrences of the word 'plane'.
// However, counter $plane will show 9 as the word 'plane' is also contained in 'airplane'.
echo "$airplane 'airplane' found.\n";
echo "$plane 'plane' found.\n";

?>