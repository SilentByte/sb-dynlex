<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

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
