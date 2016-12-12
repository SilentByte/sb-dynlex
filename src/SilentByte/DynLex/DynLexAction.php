<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace SilentByte\DynLex;

/**
 * Defines valid state actions that are used as return values
 * from lexer action functions.
 */
final class DynLexAction
{
    /**
     * Accepts the match and produces the token.
     */
    const ACCEPT = null;

    /**
     * Halts the scanning process, no further tokens will be matched.
     */
    const HALT  = 1;

    /**
     * Rejects the current match and continues with the next rule.
     */
    const REJECT = 2;

    /**
     * Disallow the instantiation of objects as this is a static class.
     */
    private function __construct()
    {
        //
    }
}
