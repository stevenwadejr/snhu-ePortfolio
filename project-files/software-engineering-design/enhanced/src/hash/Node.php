<?php

namespace stevenwadejr\hash;

use stevenwadejr\Bid;

/**
 * Node used within a hash table
 */
class Node
{
    public ?Bid $bid;

    public int $key;

    public ?Node $next = null;

    public function __construct(Bid $bid = null, int $key = PHP_INT_MAX)
    {
        $this->bid = $bid;
        $this->key = $key;
    }
}