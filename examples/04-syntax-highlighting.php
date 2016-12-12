<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

require_once './../vendor/autoload.php';

use SilentByte\DynLex\DynLexBuilder;
use SilentByte\DynLex\DynLexUtils;

// -----------------------------------------------------------------
// Create a simple syntax highlighter for parts of the PHP language.
// -----------------------------------------------------------------

$input = <<<'INPUT'
/*
    I'm a comment!
*/
$a = 0xFF;
echo "Hello World";

// This is another comment.
function square($value) {
    return $value * $value;
}

$b = square($a) * 3.14;
echo $b;
INPUT;

function html_escape($text) {
    $text = htmlspecialchars($text);
    $text = str_replace("\n", '&#10;', $text);
    return $text;
}

function highlight_code($code) {
    $lexer = (new DynLexBuilder())

    // Define the rules for matching multi-line comments and single-line comments.
    // Because comments can contain line breaks, the line counter must be adjusted manually.
    // $token->matches[1] represents the captured group, holding only the textual comment
    // without '/*', '*/', and '//'.
    ->rule('\/\*(.*?)\*\/', 'multi-comment', function($token, $state) {
        $token->value = $token->matches[1];
        $state->line += substr_count($token->text, "\n");
    })
    ->rule('\/\/(.*?)\n', 'comment', function($token, $state) {
        $token->value = $token->matches[1];
        $state->line++;
    })

    // Define the rule for matching strings. Similarily, $token->matches[1] contains the
    // textual string without delimiting quotes.
    ->rule('"([^"\n]*)"', 'string', function($token) {
        $token->value = $token->matches[1];
    })

    // Define the rule for matching numbers. In case of hexadecimal numbers,
    // the value of the token will be directly converted to decimal.
    ->rule('0x[0-9A-Fa-f]+', 'hex', function($token) {
        $token->value = hexdec($token->text);
    })
    ->rule('[0-9]+\.[0-9]+', 'float')
    ->rule('[0-9]+',         'integer')

    // Define the rule for matching keywords, variables (starting with '$') and identifiers.
    ->rule('(function|echo|return)', 'keyword')
    ->rule('\$\w+',                  'variable')
    ->rule('\w+',                    'identifier')

    // Define the rules for matching some of the available operators and braces.
    ->rule('[\*\+\-\/\=\;]',      'operator')
    ->rule('(\(|\)|\{|\}|\[|\])', 'brace')

    // Define LF as the end-of-line character. Note that this rule must be listed
    // before the white-space rule because it is more specific.
    ->newline('\n', 'new-line')

    // Also match white-space characters instead of ignoring them as they are
    // required for correct formatting of the output.
    ->rule('\s+', 'white-space')

    // Build the configured lexer.
    ->build();

    $tokens = $lexer->collect($code);
    foreach($tokens as $t) {
        $tag    = html_escape($t->rule->tag());
        $text   = html_escape($t->text);
        $value  = html_escape($t->value);
        $line   = $t->line;
        $column = $t->column;

        echo "<span class=\"token $tag\" title=\"($line, $column) $tag '$value'\">$text</span>";
    }
}

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>DynLex Syntax Highlighting Example</title>
        <style>
            body {
                font-family: Helvetica, Arial, sans-serif;
                margin: 40px;
            }

            pre {
                padding: 8px 16px;
                background-color: #272822;
                font-family: Monaco, Consolas, monospace;
                font-size: 12pt;
            }

            .token {
                cursor: pointer;
            }

            .token:hover {
                outline: 1px dashed #75715E;
            }

            .comment, .multi-comment {
                color: #75715E;
            }

            .string {
                color: #E6DB74;
            }

            .hex, .integer, .float {
                color: #AE81FF;
            }

            .keyword {
                color: #F92672;
                font-weight: bold;
            }

            .variable {
                color: #66D9EF;
            }

            .identifier {
                color: #F8F8F2;
            }

            .operator, .brace {
                color: #F8F8F2;
            }
        </style>
    </head>
    <body>
        <h1>DynLex Syntax Highlighting Example</h1>
        <p>
            This is a simple example of how to translate the resulting token stream into<br />
            syntax-highlighted HTML content.
        </p>
        <p>
            Try hovering over the individual tokens to get more information.
        </p>
        <hr />
        <pre><code><?php highlight_code($input); ?></code></pre>
        <hr />
        <a href="https://www.silentbyte.com">https://www.silentbyte.com/</a>
        <a href="https://github.com/SilentByte/sb-dynlex">https://github.com/SilentByte/sb-dynlex</a>
    </body>
</html>