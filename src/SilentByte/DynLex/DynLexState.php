<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

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
