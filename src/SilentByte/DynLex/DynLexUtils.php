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

namespace SilentByte\DynLex;

/**
 * Defines useful helper functions.
 */
class DynLexUtils
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

?>