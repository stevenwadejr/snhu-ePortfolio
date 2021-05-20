<?php

namespace stevenwadejr\binary;

use stevenwadejr\Bid;

class BinarySearchTree
{
    public ?Node $root = null;

    public int $size = 0;

    public function inOrder(): void
    {
        $this->_inOrder($this->root);
    }

    public function insert(Bid $bid): void
    {
        if ($this->root === null) {
            $this->root = new Node($bid);
        } else {
            $this->addNode($this->root, $bid);
        }

        $this->size++;
    }

    public function remove(string $bidId): void
    {
        $this->removeNode($this->root, $bidId);
    }

    public function search(string $bidId): Bid
    {
        $current = $this->root;

        while ($current !== null) {
            if (strcmp($current->bid->bidId, $bidId) === 0) {
                return $current->bid;
            }

            $current = strcmp($bidId, $current->bid->bidId) < 0
                ? $current->left
                : $current->right;
        }

        return new Bid();
    }

    public function size(): int
    {
        return $this->size;
    }

    private function addNode(Node $node, Bid $bid): void
    {
        $direction = strcmp($bid->bidId, $node->bid->bidId) < 0 ? 'left' : 'right';
        if ($node->$direction === null) {
            $node->$direction = new Node($bid);
        } else {
            $this->addNode($node->$direction, $bid);
        }
    }

    private function removeNode(?Node $node, string $bidId): ?Node
    {
        if ($node === null) {
            return null;
        }

        if (strcmp($bidId, $node->bid->bidId) < 0) {
            $node->left = $this->removeNode($node->left, $bidId);
            return $node;
        }

        if (strcmp($bidId, $node->bid->bidId) > 0) {
            $node->right = $this->removeNode($node->right, $bidId);
            return $node;
        }

        if ($node->left === null && $node->right === null) {
            $node = null;

            $this->size--;
        } elseif ($node->left !== null && $node->right === null) {
            $node = $node->right;

            $this->size--;
        } else {
            $tempNode = $node->right;

            while ($tempNode->left !== null) {
                $tempNode = $tempNode->left;
            }

            $node->bid = $tempNode->bid;

            $node->right = $this->removeNode($node->right, $tempNode->bid->bidId);
        }

        return $node;
    }

    private function _inOrder(?Node $node)
    {
        if ($node === null) {
            return;
        }

        $this->_inOrder($node->left);

        echo $node->bid->bidId
            . ': '
            . $node->bid->title
            . ' | '
            . $node->bid->amount
            . ' | '
            . $node->bid->fund
            . PHP_EOL;

        $this->_inOrder($node->right);
    }
}