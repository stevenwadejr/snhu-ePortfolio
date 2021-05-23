<?php

namespace stevenwadejr\binary;

use stevenwadejr\Bid;

/**
 * Node used within a binary search tree
 */
class Node
{
    public ?Bid $bid = null;

    public ?Node $left = null;

    public ?Node $right = null;

    public function __construct(Bid $bid = null)
    {
        $this->bid = $bid;
    }

}