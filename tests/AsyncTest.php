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
        try{
            $async_mysql = new \Jenner\Mysql\Async();
            $async_mysql->attach(
                ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
                'select * from dd'
            );
            $async_mysql->attach(
                ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
                'select * from dd limit 0, 2'
            );
            $result = $async_mysql->execute();
            $this->assertEquals($result,
                [
                    ['1', '2', '3', '4', '5'],
                    ['1', '2']
                ]);
        }catch (Exception $e){
            echo $e->getMessage();
        }

    }

}