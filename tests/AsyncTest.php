<?php

/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/20
 * Time: 16:27
 */
class AsyncTest extends PHPUnit_Framework_TestCase
{
    public function testExecute(){
        $async_mysql = new Async();
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
    }

}