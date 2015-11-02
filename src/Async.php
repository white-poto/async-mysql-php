<?php

/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/20
 * Time: 16:04
 */

namespace Jenner\Mysql;

use mysqli;
use React\Promise\Deferred;

class Async
{
    /**
     * mysql connection resource
     * @var mysqli[]
     */
    protected $links = array();

    /**
     * @var Deferred[]
     */
    protected $deferred = array();

    /**
     * @param array $config mysql connection config
     * @param string $query sql
     * @return \React\Promise\PromiseInterface
     */
    public function attach($config, $query)
    {
        $link = mysqli_connect(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['database'],
            $config['port']
        );

        if ($link === false) {
            throw new \RuntimeException(mysqli_connect_error(), mysqli_connect_errno());
        }
        $link->query($query, MYSQLI_ASYNC);

        $this->links[] = $link;
        $deferred = new Deferred();
        $this->deferred[] = $deferred;

        return $deferred->promise();
    }

    /**
     * is done ?
     *
     * @param int $seconds
     * @param int $microseconds
     * @return bool
     */
    public function isDone($seconds = 0, $microseconds = 1000)
    {
        $links = $errors = $reject = array();
        foreach ($this->links as $link) {
            $links[] = $errors[] = $reject[] = $link;
        }
        if (!mysqli_poll($links, $errors, $reject, $seconds, $microseconds)) {
            return false;
        }

        return true;
    }

    /**
     * @param bool $return
     * @return array
     */
    public function execute($return = false)
    {
        $collect = array();

        $link_count = count($this->links);
        $processed = 0;
        do {
            $links = $errors = $reject = array();
            foreach ($this->links as $link) {
                $links[] = $errors[] = $reject[] = $link;
            }
            if (!mysqli_poll($links, $errors, $reject, 0, 1000)) {
                continue;
            }
            for ($i = 0; $i < $link_count; $i++) {
                $link = $this->links[$i];
                $deferred = $this->deferred[$i];
                if (mysqli_errno($link)) {
                    if ($return) {
                        throw new \RuntimeException(mysqli_error($link), mysqli_errno($link));
                    } else {
                        $deferred->reject(array('errno' => mysqli_errno($link), 'error' => mysqli_error($link)));
                    }
                }

                if ($result = $link->reap_async_query()) {
                    if (is_object($result)) {
                        $temp = array();
                        while (($row = $result->fetch_assoc()) && $temp[] = $row) ;
                        $return ? $collect[$i] = $temp : null;
                        $deferred->resolve($temp);
                        mysqli_free_result($result);
                    } else {
                        $return ? $collect[$i] = $result : null;
                        $deferred->resolve($result);
                    }
                }
                $processed++;
            }
        } while ($processed < $link_count);

        if ($return) {
            return $collect;
        }
    }

    /**
     * close all connections
     */
    public function close()
    {
        foreach ($this->links as $link) {
            mysqli_close($link);
        }
    }

    /**
     * destroy
     */
    public function __destory()
    {
        $this->close();
    }
}
