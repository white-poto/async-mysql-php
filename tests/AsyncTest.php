<?php

/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/20
 * Time: 16:27
 */
class AsyncTest extends PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        try {
            $async_mysql = new \Jenner\Mysql\Async();
            $async_mysql->attach(
                ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port'=>3306],
                'select * from async'
            );
            $async_mysql->attach(
                ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port'=>3306],
                'select * from async limit 0, 2'
            );
            $result = $async_mysql->execute();
            $this->assertEquals($result,
                [
                    [
                        ['id' => '1', 'name' => '1'],
                        ['id' => '2', 'name' => '2'],
                        ['id' => '3', 'name' => '3'],
                        ['id' => '4', 'name' => '4'],
                        ['id' => '5', 'name' => '5'],
                    ],
                    [
                        ['id' => '1', 'name' => '1'],
                        ['id' => '2', 'name' => '2'],
                    ]
                ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

}