<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$active_group = 'default';
$query_builder = TRUE;
$hostname ='localhost';






$db['default'] = array(
    'dsn'	=> '',
    'hostname' => "mysql_makroerp",
    'username' => 'new_test',
    'password' => 'new_test',
    'database' => 'new_test',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => true,
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

$db['mobile_db'] = array(
    'dsn'       => '',
    'hostname' => 'mysql_makroerp',
    'username' => 'new_test_2',
    'password' => 'new_test_2',
    'database' => 'new_test_2',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
//    'db_debug' => (ENVIRONMENT !== 'production'),
    'db_debug' => true,
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


