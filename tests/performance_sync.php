<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/23
 * Time: 9:43
 */

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$timer = new \Jenner\Timer(\Jenner\Timer::UNIT_KB);
$timer->mark('start');
for ($i = 0; $i < 10; $i++) {
    $mysql = mysqli_connect('127.0.0.1', 'root', '', 'test', '3306');
    $result = $mysql->query("select * from async");
    $mysql = mysqli_connect('127.0.0.1', 'root', '', 'test', '3306');
    $result2 = $mysql->query("select * from async");
}
$timer->mark("stop");

$timer->printDiffReport();