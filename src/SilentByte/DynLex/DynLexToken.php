<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

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
        $this->text = $text;
        $this->value = $text;
        $this->matches = $matches;
        $this->offset = $offset;
        $this->line = $line;
        $this->column = $column;
    }
}
