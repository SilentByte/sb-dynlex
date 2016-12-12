<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

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
