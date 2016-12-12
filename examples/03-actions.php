<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

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
