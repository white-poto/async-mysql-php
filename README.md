# async-mysql-php

mysql 异步客户端，基于mysqli::poll简单封装   
当链接mysql出现错误时，会抛出异常   
当执行sql失败时，仅会在result中相应字段标志为false，不会提示错误信息   
返回结果的顺序与attach顺序一致  
接口如下： 
```php
try{
    $async_mysql = new \Jenner\Mysql\Async();
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from stu'
    );
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from stu limit 0, 3'
    );
    $result = $async_mysql->execute();
    print_r($result);
}catch (Exception $e){
    echo $e->getMessage();
}
```