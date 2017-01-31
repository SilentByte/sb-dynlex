<?php
/**
 * SilentByte DynLex Lexer Library
 * @copyright 2016 SilentByte <https://silentbyte.com/>
 * @license https://opensource.org/licenses/MIT MIT
 */

declare(strict_types = 1);

$version = exec('git symbolic-ref -q --short HEAD || git describe --tags --exact-match');
$dir = __DIR__ . '/src';

$iterator = Symfony\Component\Finder\Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir);

$options = [
    'title'     => 'SilentByte DynLex Documentation',
    'theme'     => 'sami-silentbyte',
    'build_dir' => __DIR__ . "/docs/{$version}",
    'cache_dir' => __DIR__ . "/.sami/.twig/{$version}",
];

$sami = new Sami\Sami($iterator, $options);

if (!is_dir(__DIR__ . '/.sami/themes')) {
    mkdir(__DIR__ . '/.sami/themes', 0777, true);
}

$templates = $sami['template_dirs'];
$templates[] = __DIR__ . '/.sami/themes';

$sami['template_dirs'] = $templates;

return $sami;

