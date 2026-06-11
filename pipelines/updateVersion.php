<?php
/*
 * Copyright 2023 AlexaCRM
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE
 * OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * Updates version tags in given plugin file.
 * Note: Given version tag will be ADDDED to the one presents in the file.
 *
 * @param string $file Path to the base plugin file.
 * @param string $versionTag Version tag to set up.
 *
 * @return bool
 */
function updateVersion( string $file, string $versionTag ): bool {
    $replacements = [
        '~(Version:\s+)(\S+)$~m' => '$1$2-' . $versionTag,
        '~(define\(\s+\'SMZ_WPQUOTES_VERSION\',\s+\')(\S+)(\'\s+\);)~m' => '$1$2-' . $versionTag . '$3',
    ];

    $fileContent = file_get_contents( $file );

    $fileContent = preg_replace( array_keys( $replacements ), array_values( $replacements ), $fileContent );

    return (bool)file_put_contents( $file, $fileContent );
}

$options = getopt( '', [
    'plugin::',
    'version::',
] );

$pluginName = $options['plugin'] ?? 'quotes-daily';
$versionTag = $options['version'] ?? '';

$wd = __DIR__ . "/../{$pluginName}";
$basefile = $wd . "/{$pluginName}.php";

if ( $versionTag === '' ) {
    exit( 0 );
}

$version = updateVersion( $basefile, $versionTag );

if ( !$version ) {
    fwrite( STDERR, "Failed to update package version.\n" );
    exit( 4 );
} else {
    exit( 0 );
}
