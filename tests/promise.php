<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/11/2
 * Time: 10:17
 */


require dirname(dirname(__FILE__)) . '/vendor/autoload.php';

try {
    $async_mysql = new \Jenner\Mysql\Async();
    $promise_1 = $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from stu'
    );
    $promise_1->then(
        function ($data) {
            echo 'sucess:' . $data . PHP_EOL;
        },
        function ($info) {
            echo "error:" . var_export($info, true);
        }
    );
    $promise_2 = $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from stu limit 0, 3'
    );
    $promise_2->then(
        function ($data) {
            echo 'sucess:' . $data . PHP_EOL;
        },
        function ($info) {
            echo "error:" . var_export($info, true);
        }
    );
    $async_mysql->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}