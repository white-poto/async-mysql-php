# async-mysql-php
文档：[http://www.huyanping.cn/php%E5%BC%82%E6%AD%A5%E5%B9%B6%E5%8F%91%E8%AE%BF%E9%97%AEmysql%E7%AE%80%E5%8D%95%E5%AE%9E%E7%8E%B0/](http://www.huyanping.cn/php%E5%BC%82%E6%AD%A5%E5%B9%B6%E5%8F%91%E8%AE%BF%E9%97%AEmysql%E7%AE%80%E5%8D%95%E5%AE%9E%E7%8E%B0/)
mysql 异步客户端，基于mysqli::poll简单封装   
当链接mysql出现错误或SQL执行出错时，会抛出异常      
返回结果的顺序与attach顺序一致  
接口如下： 
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

性能测试报告如下  
-------------------------
总结：异步并发的方式理论上本身就会明显优于串行的访问方式。 
测试结果表明，使用该方式可以明显提升访问mysql的速度，具体提升多少，更多的依赖于业务。
一般情况下，执行的时间取决于最复杂的一条SQL。
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