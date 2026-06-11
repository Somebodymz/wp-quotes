<?php
/*
 * Copyright 2021 AlexaCRM
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
 * Parses the plugin header to determine the version of the plugin.
 *
 * @param string $file Path to the base plugin file.
 *
 * @return string|null
 */
function parseVersion( string $file ): ?string {
    $fp = fopen( $file, 'rb' );
    $data = fread( $fp, 1024 ); // First 1KB is enough.
    fclose( $fp );

    if ( !preg_match( '~Version:\s+(\S+)$~m', $data, $matches ) ) {
        return null;
    }

    return $matches[1];
}

$options = getopt( '', [
    'plugin::',
] );

$pluginName = $options['plugin'] ?? 'quotes-daily';

$wd = __DIR__ . "/../{$pluginName}";
$basefile = $wd . "/{$pluginName}.php";

$version = parseVersion( $basefile );

if ( $version === null ) {
    fwrite( STDERR, "Could not determine package version.\n" );
    exit( 4 );
}

echo $version;
