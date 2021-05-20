<?php

namespace stevenwadejr\binary;

use stevenwadejr\Bid;

class Node
{
    public Bid $bid;

    public ?Node $left = null;

    public ?Node $right = null;

    public function __construct(Bid $bid = null)
    {
        $this->bid ??= $bid;
    }

}