<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/21
 * Time: 19:27
 */
ini_set('memory_limit', "1024M");
set_time_limit(0);

$mysql = mysqli_connect('127.0.0.1', 'root', '', 'test', '3306');
$result = $mysql->query("select * from async");
$result2 = $mysql->query("select * from async");


echo microtime() . PHP_EOL;

echo memory_get_usage() . PHP_EOL;