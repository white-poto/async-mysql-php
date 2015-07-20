<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/20
 * Time: 17:40
 */

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';


try{
    $async_mysql = new \Jenner\Mysql\Async();
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from dd'
    );
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from dd'
    );
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from dd'
    );
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from dd'
    );
    $result = $async_mysql->execute();
    var_dump($result);
}catch (Exception $e){
    echo $e->getMessage();
}