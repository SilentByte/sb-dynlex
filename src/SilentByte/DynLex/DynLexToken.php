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
 * Represents a single token that has been produced by the lexer.
 */
class DynLexToken
{
    /**
     * Stores the rule that has been matched.
     *
     * @var DynLexRule
     */
    public $rule;

    /**
     * Gets the tag of the matching rule for this token.
     *
     * @var any
     */
    public $tag;

    /**
     * Stores the text that has been matched.
     *
     * @var string
     */
    public $text;

    /**
     * Stores the value of the matched token.
     *
     * Normally, the value of the token is identical to its text if it has not been
     * changed by the user. A useful application is the direct conversion of input,
     * e.g. the text property might hold a hexadecimal string (0xFF) while the
     * value property holds its integral representation (255).for directly
     *
     * @var any
     */
    public $value;

    /**
     * Holds all matches that have been found and provides access to captured groups
     * if more than one group has been used.
     *
     * @var array
     */
    public $matches;

    /**
     * Indicates the start of the token within the input sequence in bytes.
     *
     * @var integer
     */
    public $offset;

    /**
     * Indicates the line number where the token has been found.
     *
     * @var integer
     */
    public $line;

    /**
     * Indicates the column on the line where the token has been found.
     *
     * @var integer
     */
    public $column;

    /**
     * Creates the object based on the specified arguments.
     *
     * @param DynLexRule $rule
     * @param string $text
     * @param array $matches
     * @param integer $offset
     * @param integer $line
     * @param integer $column
     */
    public function __construct($rule, $text, $matches, $offset, $line, $column)
    {
        $this->rule = $rule;
        $this->tag = $rule->tag();
        $this->text = $text;
        $this->value = $text;
        $this->matches = $matches;
        $this->offset = $offset;
        $this->line = $line;
        $this->column = $column;
    }
}
