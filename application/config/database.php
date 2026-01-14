<?php

defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn' => '',
    'hostname' => '10.5.57.119',
    'username' => 'teguh',
    'password' => 'teguh',
    'port' => '3316',

    /* 'hostname' => '192.168.0.17',
    'username' => 'fadil',
    'password' => '1', */

    'database' => 'databarang',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);


$db['dbAcct'] = array(
    'dsn' => '',
    // 'hostname' => '192.168.0.1',
    // 'username' => 'teguh',
    // 'password' => 'teguhs12345',

    'hostname' => '10.5.57.119',
    'username' => 'teguh',
    'password' => 'teguh',
    'port' => '3316',

    'database' => 'ptmsa_acct',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);

$db['dbAcctBal'] = array(
    'dsn' => '',
    // 'hostname' => '192.168.0.7',
    // 'username' => 'adminmsa',
    // 'password' => 'AdminMsa@4400865',

    'hostname' => '10.5.57.119',
    'username' => 'teguh',
    'password' => 'teguh',
    'port' => '3316',

    'database' => 'ptbalrich_dbo',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
