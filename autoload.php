<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/23
 * Time: 11:05
 */

spl_autoload_register(function($classname){
    if(stristr($classname, "Jenner\\Mysql")){
        $namespaces = explode("\\", $classname);
        $classname = $namespaces[count($namespaces) - 1];
        $file = dirname(__FILE__) . DIRECTORY_SEPARATOR
            . 'src' . DIRECTORY_SEPARATOR . $classname . '.php';

        include $file;
    }
});