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
 * A dynamically configurable lexer featuring a fluid API.
 */
class DynLexLexer
{
    /**
     * Holds all lexer rules.
     *
     * @var array
     */
    private $rules;

    /**
     * Creates the object based on the speicifed lexer rules.
     *
     * @param array $rules Array of DynLexRule objects.
     */
    public function __construct($rules)
    {
        $this->rules = $rules;
    }

    /**
     * Scans the entire input and creates an array of DynLexToken objects.
     * Skipped tokens (i.e. those without tags) will not be added.
     *
     * @param  string $input The input to be processed by the lexer.
     * @return array Array of DynLexToken objects.
     */
    public function collect($input)
    {
        $tokens = [];

        // Scan the input providing a specialized callback for the
        // population of the token array.
        $this->scan($input, function($token) use (&$tokens) {
            // Only include tokens with defined tags.
            if($token->rule->tag()) {
                $tokens[] = $token;
            }
        });

        return $tokens;
    }

    /**
     * Scans the entire input and calls the specified callback for each match.
     *
     * @param  string $input The input to be processed by the lexer.
     * @param  callable $callback User defined callback.
     */
    public function scan($input, $callback = null)
    {
        $inputLength = strlen($input);
        $inputOffset = 0;

        $state = new DynLexState();
        $matches = null;

        while($inputOffset < $inputLength)
        {
            foreach($this->rules as $rule) {
                if(preg_match($rule->pattern(), $input, $matches, 0, $inputOffset)) {
                    // Only consider the entire match. If more than one match is present,
                    // e.g. when groups have been used within the pattern, then it is the
                    // user's responsibility to update the value within the rule's action.
                    $text = $matches[0];
                    $token = new DynLexToken($rule, $text, $matches,
                        $inputOffset, $state->line, $state->column);

                    if($rule->action()) {
                        $actionResult = $rule->action()($token, $state);
                        if($actionResult === DynLexAction::HALT) {
                            // Halt scanning if the user requested aborting the process.
                            return;
                        }
                        else if($actionResult === DynLexAction::REJECT) {
                            // Try matching next rule.
                            continue;
                        }
                    }

                    if($callback) {
                        $actionResult = $callback($token, $state);
                        if($actionResult === DynLexAction::HALT) {
                            // Halt scanning if the user requested aborting the process.
                            return;
                        }
                        else if($actionResult === DynLexAction::REJECT) {
                            // Try matching next rule.
                            continue;
                        }
                    }

                    $textLength = strlen($text);
                    $inputOffset += $textLength;

                    if($rule->newline()) {
                        $state->line++;
                        $state->column = 1;
                    }
                    else {
                        $state->column += $textLength;
                    }

                    // Rule has been accepted, continue scanning.
                    continue 2;
                }
            }

            throw new \UnexpectedValueException("No rule matches input at"
                . " (line: $state->line, column: $state->column, offset: $inputOffset).");
        }
    }
}
