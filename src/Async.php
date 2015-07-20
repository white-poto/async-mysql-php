<?php

/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/7/20
 * Time: 16:04
 */
class Async
{
    protected $links;

    public function attach($connection, $query)
    {
        $link = mysqli_connect($connection['host'], $connection['user'], $connection['password'], $connection['database']);
        $link->query($query, MYSQLI_ASYNC);
        array_push($this->links, $link);
    }

    public function execute()
    {
        $collect = array();

        $processed = 0;
        do {
            $links = $errors = $reject = array();
            foreach ($this->links as $link) {
                $links[] = $errors[] = $reject[] = $link;
            }
            if (!mysqli_poll($links, $errors, $reject, 1)) {
                continue;
            }
            for ($i = 0; $i < count($this->links); $i++) {
                $link = $this->links[$i];
                if ($result = $link->reap_async_query()) {
                    $collect[$i] = $result;
                    if (is_object($result))
                        mysqli_free_result($result);
                } else {
                    throw new Exception(mysqli_error($link), mysqli_errno($link));
                }
                $processed++;
            }
        } while ($processed < count($this->links));

        return $collect;
    }
}