<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace SilentByte\DynLex;

/**
 * Defines useful helper functions.
 */
final class DynLexUtils
{
    /**
     * Disallow the instantiation of objects as this is a static class.
     */
    private function __construct()
    {
        //
    }

    /**
     * Outputs the specified list of tokens in a tabular format.
     *
     * @param  array $tokens Array of DynLexToken objects.
     */
    public static function dumpTokens($tokens)
    {
        echo "-------------------------------------\n";

        echo str_pad('tag', 12, ' ', STR_PAD_RIGHT), '  ',
             str_pad('off',  4, ' ', STR_PAD_LEFT),  '  ',
             str_pad('ln',   4, ' ', STR_PAD_LEFT),  '  ',
             str_pad('col',  4, ' ', STR_PAD_LEFT),  '  ',
             'value', "\n";

        echo "-------------------------------------\n";

        foreach($tokens as $t) {
            echo str_pad($t->rule->tag(), 12, ' ', STR_PAD_RIGHT), '  ',
                str_pad($t->offset,        4, ' ', STR_PAD_LEFT),  '  ',
                str_pad($t->line,          4, ' ', STR_PAD_LEFT),  '  ',
                str_pad($t->column,        4, ' ', STR_PAD_LEFT),  '  ',
                $t->value, "\n";
        }

        echo "-------------------------------------\n";
    }
}
