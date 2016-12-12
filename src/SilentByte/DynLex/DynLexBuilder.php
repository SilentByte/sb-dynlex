<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace SilentByte\DynLex;

/**
 * Provides a simple way to create and configure a new lexer.
 */
class DynLexBuilder
{
    /**
     * Holds all defined rules.
     *
     * @var array
     */
    private $rules;

    /**
     * Holds the default rule defined by the user or null if not used.
     *
     * @var DynLexRule
     */
    private $defaultRule;

    /**
     * Adds a new rule to the list.
     *
     * @param DynLexRule $rule
     */
    private function addRule($rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * Creates a new builder object with the default configuration.
     */
    public function __construct()
    {
        $this->rules = [];
        $this->defaultRule = null;
    }

    /**
     * Creates a new lexer rule based on pattern, tag, and an optional action.
     *
     * @param string $pattern Regular expression pattern for the rule.
     * @param any $tag User defined value identifying the match.
     * @param callable $action Action to be executed when the rule is matched against the input.
     *
     * @return DynLexBuilder
     */
    public function rule($pattern, $tag, $action = null)
    {
        $this->addRule(new DynLexRule($pattern, $tag, $action));
        return $this;
    }

    /**
     * Creates a new lexer rule that matches a token representing a line ending,
     * subsequently increasing the internal line counter.
     *
     * @param string $pattern Regular expression pattern for the rule.
     * @param any $tag User defined value identifying the match.
     * @param callable $action Action to be executed when the rule is matched against the input.
     *
     * @return DynLexBuilder
     */
    public function newline($pattern, $tag = null, $action = null)
    {
        $this->addRule(new DynLexRule($pattern, $tag, $action, true));
        return $this;
    }

    /**
     * Creates a new lexer rule whose matches will not be part of the reported tokens.
     *
     * @param string $pattern Regular expression pattern for the rule.
     * @param callable $action Action to be executed when the rule is matched against the input.
     *
     * @return DynLexBuilder
     */
    public function skip($pattern, $action = null)
    {
        $this->addRule(new DynLexRule($pattern, null, $action));
        return $this;
    }

    /**
     * Creates a new lexer rule whose matches will not be part of the reported tokens.
     *
     * @param callable $action Action to be executed when the rule is matched against the input.
     * @return DynLexBuilder
     */
    public function default($action = null)
    {
        $this->defaultRule = new DynLexRule('.', null, $action);
        return $this;
    }

    /**
     * Builds the lexer based on the previously specified configuration.
     *
     * @return DynLexLexer
     */
    public function build()
    {
        if($this->defaultRule === null) {
            return new DynLexLexer($this->rules);
        }

        return new DynLexLexer(array_merge($this->rules, [$this->defaultRule]));
    }
}
