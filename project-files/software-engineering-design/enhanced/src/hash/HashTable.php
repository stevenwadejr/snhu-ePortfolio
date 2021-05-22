<?php

namespace stevenwadejr\hash;

use Generator;
use stevenwadejr\Bid;

class HashTable
{
    public const DEFAULT_SIZE = 179;

    private array $nodes = [];

    private int $tableSize;

    public function __construct(int $tableSize = self::DEFAULT_SIZE)
    {
        $this->tableSize = $tableSize;
    }

    private function hash(int $key): int
    {
        return $key % $this->tableSize;
    }

    public function insert(Bid $bid): void
    {
        $key = $this->hash((int)$bid->bidId);

        /** @var Node|null $headNode */
        $headNode = $this->nodes[$key] ?? null;
        $oldNode = $headNode;

        if ($oldNode === null) {
            $this->nodes[$key] = new Node($bid, $key);
            return;
        }

        while ($oldNode !== null) {
            $oldNode = $oldNode->next;
        }

        if ($oldNode === null) {
            $oldNode = $headNode;
        }

        $oldNode->next = new Node($bid, $key);
    }

    public function printAll(): Generator
    {
        ksort($this->nodes);
        foreach ($this->nodes as $node) {
            $response = 'Key ';

            $isFirst = true;

            while ($node !== null) {
                $bid = $node->bid;

                $response .= sprintf(
                    '%s%s: %s | %s | %s | %s',
                    (!$isFirst ? PHP_EOL . '    ' : ''),
                    $node->key,
                    $bid->bidId,
                    $bid->title,
                    $bid->amount,
                    $bid->fund
                );

                $isFirst = false;

                $node = $node->next;
            }

            yield $response;
        }
    }

    public function remove(string $bidId): void
    {
        $key = $this->hash((int)$bidId);

        $node = $this->nodes[$key] ?? null;

        if ($node === null) {
            return;
        }

        if (strcmp($node->bid->bidId, $bidId) === 0) {
            $tempNode = $node->next;

            unset($this->nodes[$key]);

            if ($tempNode !== null) {
                $this->nodes[$key] = $tempNode;
            }

            return;
        }

        $current = $node;

        while ($current !== null && $current->next !== null) {
            if (strcmp($current->next->bid->bidId, $bidId) === 0) {
                $tempNode = $current->next;

                $current->next = $tempNode->next;

                unset($tempNode);

                return;
            }

            $current = $current->next;
        }
    }

    public function search(string $bidId): ?Bid
    {
        $key = $this->hash((int)$bidId);

        $node = $this->nodes[$key] ?? null;

        if ($node === null) {
            return null;
        }

        if (strcmp($node->bid->bidId, $bidId) === 0) {
            return $node->bid;
        }

        while ($node !== null) {
            if (strcmp($node->bid->bidId, $bidId) === 0) {
                return $node->bid;
            }

            $node = $node->next;
        }

        return null;
    }

    public function countNodes(): int
    {
        return count($this->nodes);
    }
}