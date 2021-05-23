<?php

namespace stevenwadejr\linked;

use stevenwadejr\Bid;

/**
 * Node used within a linked list
 */
class Node
{
    public Bid $bid;

    public ?Node $next = null;

    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }
}