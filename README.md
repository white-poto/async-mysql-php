async-mysql-php Great Project
================
async mysql client  
[中文README](https://github.com/huyanping/async-mysql-php/blob/master/README.ZH.MD)  
Doc：[async-mysql-php](http://www.huyanping.cn/php%E5%BC%82%E6%AD%A5%E5%B9%B6%E5%8F%91%E8%AE%BF%E9%97%AEmysql%E7%AE%80%E5%8D%95%E5%AE%9E%E7%8E%B0/)
 
Import
---------------
`composer require jenner/async-mysql-php`  
Or  
`require /path/to/async-mysql-php/autoload.php`  

Details
-------------
+ based on `mysqli::poll`   
+ throw `RuntimeException` when mysql connection or sql is error      
+ the return value's order is same to the order that you call `attach` method
+ every `attach` method will return a `Promise` object, you can call 
`Process::then` method to defer the data processing.

Interface
----------------
+ attach(),submit async mysql task
+ isDone(),check all the task whether complete
+ execute(), get the result 

History
-------------------
+ add `isDone` method to check whether complete. it will check every thousand microsecond.
+ add `react/promise` package for asynchronous processing data.

Notice
-----------------
The async object will send the request to when you call the `attach` method. 
mysql server. Actually the async object will just check all the task whether 
complete and return result, when you call `execute` method.So you can do anything 
you want between `attach` and `execute`, for example:request a url and call `execute` 
after the request is done.

example: 
```php
try{
    $async_mysql = new \Jenner\Mysql\Async();
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port'=>3306],
        'select * from stu'
    );
    $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test', 'port'=>3306],
        'select * from stu limit 0, 3'
    );
    $result = $async_mysql->execute();
    print_r($result);
}catch (Exception $e){
    echo $e->getMessage();
}
```

use promise:
```php
try {
    $async_mysql = new \Jenner\Mysql\Async();
    $promise_1 = $async_mysql->attach(
        ['host' => '127.0.0.1', 'user' => 'root', 'password' => '', 'database' => 'test'],
        'select * from stu'
    );
    $promise_1->then(
        function ($data) {
            echo 'sucess:' . var_export($data, true) . PHP_EOL;
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
            echo 'sucess:' . var_export($data, true) . PHP_EOL;
        },
        function ($info) {
            echo "error:" . var_export($info, true);
        }
    );
    $async_mysql->execute();
} catch (Exception $e) {
    echo $e->getMessage();
}
```


performance tests
-------------------------
Summary:async-mysql is really faster than sync-mysql.  
Based on the performance test result, async-mysql can improve performance.
How much it can improve is depend on what your code want to do.
In general case, the execution time is depend on the most complex sql.
The memory used will be improved because the async-mysql will get all the result 
at the same time.
```shell
# 同步
[root@iZ942077c78Z async-mysql-php]# php tests/performance_sync.php 
------------------------------------------
mark:[total diff]
time:4.2648551464081s
memory_real:18944KB
memory_emalloc:18377.171875KB
memory_peak_real:28416KB
memory_peak_emalloc:27560.3828125KB
[root@iZ942077c78Z async-mysql-php]# php tests/performance_sync.php 
------------------------------------------
mark:[total diff]
time:4.2285549640656s
memory_real:18944KB
memory_emalloc:18377.171875KB
memory_peak_real:28416KB
memory_peak_emalloc:27560.3828125KB
[root@iZ942077c78Z async-mysql-php]# php tests/performance_async.php  
------------------------------------------
mark:[total diff]
time:1.455677986145s
memory_real:38144KB
memory_emalloc:32574.015625KB
memory_peak_real:66816KB
memory_peak_emalloc:65709.7734375KB
# 异步
[root@iZ942077c78Z async-mysql-php]# php tests/performance_async.php 
------------------------------------------
mark:[total diff]
time:1.8936941623688s
memory_real:38144KB
memory_emalloc:32574.015625KB
memory_peak_real:66816KB
memory_peak_emalloc:65709.7734375KB
[root@iZ942077c78Z async-mysql-php]# php tests/performance_async.php 
------------------------------------------
mark:[total diff]
time:1.5208158493042s
memory_real:38144KB
memory_emalloc:32574.015625KB
memory_peak_real:66816KB
memory_peak_emalloc:65709.7734375KB
```
