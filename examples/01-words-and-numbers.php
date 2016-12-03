<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

require_once './../vendor/autoload.php';

use SilentByte\DynLex\DynLexBuilder;
use SilentByte\DynLex\DynLexUtils;

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

    // Build the lexer based on the given rule set.
    ->build();

$tokens = $lexer->collect($input);
DynLexUtils::dumpTokens($tokens);
