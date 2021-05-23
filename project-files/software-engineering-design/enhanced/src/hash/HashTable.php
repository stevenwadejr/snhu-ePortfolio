<?php

namespace stevenwadejr\hash;

use Generator;
use stevenwadejr\Bid;

class HashTable
{
    public const DEFAULT_SIZE = 179;

    /**
     * @var Node[] Holds all of the Nodes in this table
     */
    private array $nodes = [];

    /**
     * @var int The size of the table used to calculate the hash
     */
    private int $tableSize;

    public function __construct(int $tableSize = self::DEFAULT_SIZE)
    {
        $this->tableSize = $tableSize;
    }

    /**
     * Calculate the hash value of a given key.
     *
     * @param int $key
     * @return int
     */
    private function hash(int $key): int
    {
        // // Run a mod function on the key divided by the size of the table and return the remainder
        return $key % $this->tableSize;
    }

    /**
     * Insert a Bid
     * @param Bid $bid The Bid to be inserted
     */
    public function insert(Bid $bid): void
    {
        // Create a hashed key from the bid ID
        $key = $this->hash((int)$bid->bidId);

        // Find the node corresponding to the calculated key
        $headNode = $this->nodes[$key] ?? null;
        $oldNode = $headNode;

        // If no node is found then we can insert a new one here
        if ($oldNode === null) {
            // Create a new node containing the bid and insert it into the nodes
            // array with an offset value equal to the hashed key.
            $this->nodes[$key] = new Node($bid, $key);

            // Nothing more to do, bail.
            return;
        }

        // At this point there are more than one nodes in this chain so we need
        // to loop through them until we find the last one in the list.
        while ($oldNode->next !== null) {
            // Just keep setting the old node to the next one so we can reach the end.
            $oldNode = $oldNode->next;
        }

        // Finally at the end of the list, create a new bid node and set it to the next
        // value on the last node in this keyed list.
        $oldNode->next = new Node($bid, $key);
    }

    /**
     * Return a list of all nodes to be printed.
     *
     * @return Generator Holds a string representation of each node and its children
     */
    public function printAll(): Generator
    {
        // Put the nodes in order by index
        ksort($this->nodes);

        // Loop through all the nodes
        foreach ($this->nodes as $node) {
            $response = 'Key ';

            // Whether this is the first node in the chain at all
            $isFirst = true;

            // Loop through the chain until the end is found
            while ($node !== null) {

                $response .= sprintf(
                    '%s%s: %s | %s | %s | %s',
                    (!$isFirst ? PHP_EOL . '    ' : ''),
                    $node->key,
                    $node->bid->bidId,
                    $node->bid->title,
                    $node->bid->amount,
                    $node->bid->fund
                );

                // After the first iteration this is no longer the first
                $isFirst = false;

                // Update the current node to the value of the next
                $node = $node->next;
            }

            // Yield the string response of the chain to be printed
            yield $response;
        }
    }

    /**
     * Remove a Bid
     *
     * @param string $bidId The ID of the Bid to remove
     */
    public function remove(string $bidId): void
    {
        // Create a hashed key from the bid ID
        $key = $this->hash((int)$bidId);

        // Find the first node in the table matching the key
        $node = $this->nodes[$key] ?? null;

        // If no node was found, bail
        if ($node === null) {
            return;
        }

        // Found at the head of the list
        if (strcmp($node->bid->bidId, $bidId) === 0) {
            // Create a temp node pointing to the next after this current one.
            $tempNode = $node->next;

            // Delete the nodes from the nodes array
            unset($this->nodes[$key]);

            // If the temp node isn't null (meaning there are more children in
            // the chain), then we re-insert them into the nodes array at the same position.
            if ($tempNode !== null) {
                $this->nodes[$key] = $tempNode;
            }

            // No further processing needed, bail
            return;
        }

        // Create a current node that initially points to the given node
        $current = $node;

        // Loop until the end of the list
        while ($current !== null && $current->next !== null) {
            // If the next node's bidId is the same as the bidId passed in
            // then we should execute this block of code to remove the node from the list.
            if (strcmp($current->next->bid->bidId, $bidId) === 0) {
                // Create a temp node that references the next in the list
                $tempNode = $current->next;

                // We're looking one ahead here, so we want to set the current node's
                // `next` to be the next's `next` so we can remove the actual next node.
                $current->next = $tempNode->next;

                // Remove the next node
                unset($tempNode);

                // Bail out of the loop and function since we found the node to remove
                return;
            }

            // Set the current to the next node so we can continue the loop
            $current = $current->next;
        }
    }

    /**
     * Search for a Bid
     *
     * @param string $bidId The ID of the bid to search for
     * @return Bid|null The found bid or null if nothing found
     */
    public function search(string $bidId): ?Bid
    {
        // Create a hashed key from the bid ID
        $key = $this->hash((int)$bidId);

        // Find the root node at the given index
        $node = $this->nodes[$key] ?? null;

        // If no valid node was found, we can bail
        if ($node === null) {
            return null;
        }

        // If a valid node was found, AND the bid ID matches
        // the one we're looking for, then return it.
        if (strcmp($node->bid->bidId, $bidId) === 0) {
            return $node->bid;
        }

        // Now we've found a node and we have to loop through the chain
        while ($node !== null) {
            // If the bid ID matches, return the bid.
            if (strcmp($node->bid->bidId, $bidId) === 0) {
                return $node->bid;
            }

            // Update the value of the node to the next node to keep the loop going.
            $node = $node->next;
        }

        // No matching bid was found
        return null;
    }

    /**
     * Count the nodes in the table
     *
     * @return int The number of nodes in the table
     */
    public function countNodes(): int
    {
        return count($this->nodes);
    }
}