<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/21
 * Time: 19:17
 */
require dirname(dirname(__FILE__)) . '/vendor/autoload.php';
ini_set('memory_limit', 0);
set_time_limit(0);

echo microtime() . PHP_EOL;
try{
    $async_mysql = new \Jenner\Mysql\Async();
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from async'
    );
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from async'
    );
    $result = $async_mysql->execute();
}catch (Exception $e){
    echo $e->getMessage();
}

echo microtime() . PHP_EOL;

echo memory_get_usage() . PHP_EOL;