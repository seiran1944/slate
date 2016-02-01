<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
    'type'           => 'mysqli',
    'connection'     => array(
        'hostname'       => '127.0.0.1',
        'port'           => '3306',
        'database'       => 'BuildSystem',
        'username'       => 'root',
        'password'       => '1234',
        'persistent'     => false,
        'compress'       => false,
    ),
    'identifier'     => '`',
    'table_prefix'   => '',
    'charset'        => 'utf8',
    'enable_cache'   => true,
    'profiling'      => false,
    'readonly'       => false,
);
