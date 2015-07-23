<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/23
 * Time: 9:37
 */

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$timer = new \Jenner\Timer(\Jenner\Timer::UNIT_KB);
$timer->mark("start");
for ($i = 0; $i < 10; $i++) {
    try {
        $async_mysql = new \Jenner\Mysql\Async();
        $async_mysql->attach(
            ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port' => 3306],
            'select ID, NAME from async'
        );
        $async_mysql->attach(
            ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port' => 3306],
            'select ID, NAME from async'
        );
        $result = $async_mysql->execute();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
$timer->mark("stop");

$timer->printDiffReport();
