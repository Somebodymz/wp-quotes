<?php
/*
 * Copyright 2020 AlexaCRM
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
function parseVersion( string $file ): ?string{
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
    'path::',
] );

$pluginName = $options['plugin'] ?? 'quotes-daily';
$packagePath = $options['path'] ?? 'https://wpab.blob.core.windows.net/quotes-daily-dev';

$wd = __DIR__ . '/../' . $pluginName;

$changelog = $wd . '/CHANGELOG.md';
$readme = $wd . '/README.md';
$basefile = $wd . "/{$pluginName}.php";

$manifest = [
    'version' => '',
    'packageUrl' => '',
    'changelog' => '',
    'description' => '',
];

$changelogValue = shell_exec( "markdown {$changelog}" );
if ( $changelogValue === null ) {
    fwrite( STDERR, "Could not render markdown for the changelog.\n" );
    exit( 2 );
}
$manifest['changelog'] = $changelogValue;

$readmeValue = shell_exec( "markdown {$readme}" );
if ( $readmeValue === null ) {
    fwrite( STDERR, "Could not render markdown for the readme.\n" );
    exit( 3 );
}
$manifest['description'] = $readmeValue;

$version = parseVersion( $basefile );
if ( $version === null ) {
    fwrite( STDERR, "Could not determine package version.\n" );
    exit( 4 );
}
$manifest['version'] = $version;

$manifest['packageUrl'] = "{$packagePath}/{$pluginName}_{$version}.zip";

echo json_encode( $manifest ) . "\n";
