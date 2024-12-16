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

$db['pgsql'] = array(
    'dsn'      => '',
    'hostname' => 'localhost', // PostgreSQL sunucusunun adresi (örneğin, IP adresi veya domain)
    'username' => 'makro',  // PostgreSQL kullanıcı adı
    'password' => 'makro7373',     // PostgreSQL şifresi
    'database' => 'makrodb', // PostgreSQL veritabanı adı
    'dbdriver' => 'postgre',   // PostgreSQL için 'postgre' kullanılır
    'port'     => 5432,        // PostgreSQL varsayılan portu
    'dbprefix' => '',
    'pconnect' => FALSE,       // Kalıcı bağlantıyı devre dışı bırakın
    'db_debug' => TRUE,        // Hata ayıklamayı aktif edin
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt'  => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);


