<?php

/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/20
 * Time: 16:27
 */
ini_set('memory_limit', "1024M");
set_time_limit(0);

class AsyncTest extends PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        try {
            $async_mysql = new \Jenner\Mysql\Async();
            $async_mysql->attach(
                ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port'=>3306],
                'select ID,NAME from async'
            );
            $async_mysql->attach(
                ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port'=>3306],
                'select ID,NAME from async'
            );
            $result = $async_mysql->execute();

            $sync_result = array();
            $mysql = mysqli_connect('127.0.0.1', 'root', '', 'test', 3306);
            $sync_result[] = $mysql->query("select ID,NAME from async");
            $sync_result[] = $mysql->query("select ID,NAME from async");

            $this->assertEquals($result, $sync_result);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

}