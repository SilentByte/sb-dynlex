
DynLex Dynamically Configurable Lexer Library
=============================================
[![Build Status](https://travis-ci.org/SilentByte/sb-dynlex.svg?branch=master)](https://travis-ci.org/SilentByte/sb-dynlex)
[![Latest Stable Version](http://img.shields.io/packagist/v/silentbyte/sb-dynlex.svg)](https://packagist.org/packages/silentbyte/sb-dynlex)
[![MIT License](https://img.shields.io/badge/license-MIT%20License-blue.svg)](https://opensource.org/licenses/MIT)

This is the main repository of the SilentByte DynLex Lexer Library.

DynLex is an easy-to-use library for PHP that provides the functionality to create and use dynamically configurable lexers accessed via a fluid interface.

Official documentations can be found here: <http://docs.silentbyte.com/dynlex>


## Installation

To install the latest version, either checkout and include the source directly or use:

```bash
$ composer require silentbyte/sb-dynlex
```


## General Usage

DynLex allows the definition of a set of lexer rules that determine how the input is scanned and what tokens can be created. The following code is a simple example that tokenizes words and numbers:

```php
<?php

use SilentByte\DynLex\DynLexUtils;
use SilentByte\DynLex\DynLexBuilder;

$input = "Hello world 8273 this 919 28 is a 12 39 44 string"
    . "consisting of 328 words 003 and numbers 283";

$lexer = (new DynLexBuilder())
    ->rule('[a-zA-z]+', 'word')
    ->rule('[0-9]+',    'number')
    ->skip('.')
    ->build();

$tokens = $lexer->collect($input);
DynLexUtils::dumpTokens($tokens);

// [Output]
// -------------------------------------
// tag            off    ln   col  value
// -------------------------------------
// word             0     1     1  Hello
// word             6     1     7  world
// number          12     1    13  8273
// word            17     1    18  this
// number          22     1    23  919
// ...

?>
```

DynLex also allows the specification of lexer actions that will be executed each time the associated token is matched in the input stream. Extending the previous example, we can implement a program that counts the number of words and numbers within the input stream:

```php
<?php

use SilentByte\DynLex\DynLexUtils;
use SilentByte\DynLex\DynLexBuilder;

$words = 0;
$numbers = 0;

$input = "hello world 8273 this 919 28 is a 12 39 44 string"
    . "consisting of 328 words 003 and numbers 283";

$lexer = (new DynLexBuilder())
    ->rule('[a-z]+', 'word',   function() use (&$words)   { $words++; })
    ->rule('[0-9]+', 'number', function() use (&$numbers) { $numbers++; })
    ->skip('.')
    ->build();

$tokens = $lexer->collect($input);
DynLexUtils::dumpTokens($tokens);

echo "$words words found.\n";
echo "$numbers numbers found.\n";

// [Output]
// -------------------------------------
// tag            off    ln   col  value
// -------------------------------------
// word             0     1     1  hello
// word             6     1     7  world
// number          12     1    13  8273
// word            17     1    18  this
// number          22     1    23  919
// ...
// -------------------------------------
// 11 words found.
// 9 numbers found.

?>
```

Using this concept, it is possible to easily create lexers for different kinds of applications. A more elaborate example that demonstrates how to use DynLex to create HTML syntax highlighters for programming languages can be found under `examples/04-syntax-highlighting.php`.

It is generally advised to check out the `examples` folder for further information and examples on how to use DynLex. Also have a look into the source code for more detailed documentation.


## Contributing
See [CONTRIBUTING.md](CONTRIBUTING.md).


## FAQ

### Under what license is DynLex released?
MIT license. Check out `license.txt` for details. More information regarding the MIT license can be found here: <https://opensource.org/licenses/MIT>

### Why do rules sometimes not get matched correctly?
You have to ensure that rules that may conflict with each other are listed in the correct order from most specific to most general. For example, if you want to tokenize integers (`[0-9]+`) and floats (`[0-9]+\.[0-9]+`), the rule for floats must be listed before the rule for integers because the integer rule matches the first part of the float rule.

