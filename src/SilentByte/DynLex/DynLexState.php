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
 * Represents the current state of the lexer.
 */
class DynLexState
{
    /**
     * Holds the current line number.
     *
     * @var integer
     */
    public $line;

    /**
     * Holds the column on the current line number.
     *
     * @var integer
     */
    public $column;

    /**
     * Stores states are required by the user.
     *
     * @var array
     */
    private $stack;

    /**
     * Creates the object with default values.
     */
    public function __construct()
    {
        $this->line = 1;
        $this->column = 1;

        $this->stack = [];
    }

    /**
     * Pushes a user defined value onto the stack.
     *
     * @param any $value Value to be pushed onto the stack.
     */
    public function push($value)
    {
        $this->stack[] = $value;
    }

    /**
     * Removes and returns the top value from the stack.
     *
     * @return any User defined value.
     */
    public function pop()
    {
        if(empty($stack)) {
            throw new \UnderflowException('State stack is empty.');
        }

        return array_pop($this->stack);
    }

    /**
     * Returns the top-most value on the stack without removing it.
     *
     * @return any User defined value.
     */
    public function peek()
    {
        if(empty($stack)) {
            throw new \UnderflowException('State stack is empty.');
        }

        return end($this->stack);
    }
}

?>