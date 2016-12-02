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

?>