<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace SilentByte\DynLex;

/**
 * Represents a single lexer rule consisting of the pattern, tag, and action.
 */
class DynLexRule
{
    /**
     * Holds the modified regular expression pattern with added options.
     *
     * @var string
     */
    private $pattern;

    /**
     * Holds the associated user specified tag value.
     *
     * @var any
     */
    private $tag;

    /**
     * Callable action to be executed each time the rule has been matched.
     *
     * @var callable
     */
    private $action;

    /**
     * Indicates whether this rule increases the line number when matched.
     *
     * @var boolean
     */
    private $newline;

    /**
     * Checks whether the specified pattern is a valid regular expression.
     *
     * @return boolean True if valid, false otherwise.
     */
    private static function isValidPattern($pattern)
    {
        // Check validity by matching an empty string.
        // Call will fail if regular expression is invalid.
        return @preg_match($pattern, null) !== false;
    }

    /**
     * Creates the object based on the specified information and
     * modifies the pattern to include required options.
     *
     * @param string $pattern Regular expression pattern for the rule.
     * @param any $tag User defined value identifying the match.
     * @param callable $action Action to be executed when the rule is matched against the input.
     * @param boolean $newline Indicates whether this rule increases the line number when matched.
     */
    public function __construct($pattern, $tag, $action, $newline = false) {
        $this->pattern = "/${pattern}/As";

        if(!self::isValidPattern($this->pattern)) {
            throw new \InvalidArgumentException("Pattern '$this->pattern' is invalid.'");
        }

        $this->tag = $tag;
        $this->action = $action;
        $this->newline = $newline;
    }

    /**
     * Gets the modified pattern.
     *
     * @return string
     */
    public function pattern()
    {
        return $this->pattern;
    }

    /**
     * Gets the user defined tag object.
     *
     * @return any
     */
    public function tag()
    {
        return $this->tag;
    }

    /**
     * Gets the callable action or null of undefined.
     *
     * @return callable.
     */
    public function action()
    {
        return $this->action;
    }

    /**
     * Indicates whether this rule increases the line number when matched.
     *
     * @return boolean
     */
    public function newline()
    {
        return $this->newline;
    }
}
