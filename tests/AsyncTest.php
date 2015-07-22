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
                'select ID,NAME from async limit 0, 2'
            );
            $async_mysql->attach(
                ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port'=>3306],
                'select ID,NAME from async limit 0, 2'
            );
            $result = $async_mysql->execute();

            $sync_result = $temp_result = array();
            $mysql = mysqli_connect('127.0.0.1', 'root', '', 'test', 3306);
            $temp = $mysql->query("select ID,NAME from async limit 0, 2");
            while(($row = $temp->fetch_row()) && $temp_result[] = $row);
            $sync_result[] = $temp_result;
            $temp_result = array();
            $temp = $mysql->query("select ID,NAME from async limit 0, 2");
            while(($row = $temp->fetch_row()) && $temp_result[] = $row);
            $sync_result[] = $temp_result;

            var_dump($result);
            var_dump($sync_result);

            $this->assertEquals($result, $sync_result);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

}