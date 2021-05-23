<?php

namespace stevenwadejr\linked;

use Generator;
use stevenwadejr\Bid;

class LinkedList
{
    private ?Node $head = null;

    private ?Node $tail = null;

    private int $size = 0;

    /**
     * Class Destructor
     *
     * When the class instance is deleted from memory, loop through each node
     * and delete it as well.
     */
    public function __destruct()
    {
        $current = $this->head;

        // Do this loop while the current variable isn't null
        while ($current !== null) {
            // Create a temp variable set to the current node in the loop
            $tempNode = $current;

            // Set the current value to the next node in order
            $current = $current->next;

            // Delete the temp node and move on to process the next current node
            // in the next loop iteration.
            unset($tempNode);
        }
    }

    /**
     * Append a new bid to the end of the list
     *
     * @param Bid $bid
     */
    public function append(Bid $bid): void
    {
        // Create a new Node with the passed in Bid
        $newNode = new Node($bid);

        // If the head of the list is null, then this new node
        // should be promoted to the head.
        if ($this->head === null) {
            $this->head = $newNode;
        } elseif ($this->tail !== null) {
            // If the tail already exists, we're going to update
            // the tail's `next` value to be the new node.
            $this->tail->next = $newNode;
        }

        // Since we're appending this to the list, always make the new node the tail
        $this->tail = $newNode;

        // Increment the size of this list
        $this->size++;
    }

    /**
     * Prepend a new bid to the start of the list
     *
     * @param Bid $bid
     */
    public function prepend(Bid $bid): void
    {
        // Create a new Node with the passed in Bid
        $newNode = new Node($bid);

        // If the head of the list isn't null (meaning a head
        // already exists), then set the new node's `next` value
        // to the current head.
        if ($this->head !== null) {
            $newNode->next = $this->head;
        }

        // Since we're prepending, the new node will always be the head of the list
        $this->head = $newNode;

        // Increment the size of this list
        $this->size++;
    }

    /**
     * Outputs a string representation of the bids within the list, one by one.
     *
     * @return Generator
     */
    public function printList(): Generator
    {
        // Create a current variable that initializes to the list's head
        $current = $this->head;

        // Do this loop while the current variable isn't null
        while ($current !== null) {
            // Temporary variable pointing to the current bid to reduce code
            // and allow $current to be reset prior to yielding from the function.
            $bid = $current->bid;

            // Set the current value to the next node in order
            $current = $current->next;

            // Yield a string representation of each list item one at a time
            yield sprintf(
                '%s: %s | %s | %s',
                $bid->bidId,
                $bid->title,
                $bid->amount,
                $bid->fund
            );
        }
    }

    /**
     * Remove a specific bid from the list
     *
     * @param string $bidId The ID of the bid to remove from the list
     */
    public function remove(string $bidId): void
    {
        // Two checks here:
        //   1) If the head isn't null (head is a valid Node)
        //   2) AND, the head's Bid $bidId is equal to the passed in $bidId
        // If these two conditions are met, that means the bid we want
        // to remove is the head of the list.
        if ($this->head !== null && strcmp($this->head->bid->bidId, $bidId) === 0) {
            // Create a temporary node variable that points to the head's next value
            $tempNode = $this->head->next;

            // Delete the head
            unset($this->head);

            // Now, reset the head of the list to the temp node (the second one
            // in the list - $head->next).
            $this->head = $tempNode;

            // Decrement the size of the list
            $this->size--;

            // Bail early since we found our match and removed it.
            return;
        }

        // Create a node variable that points to the current place
        // in the list - starting with the head.
        $current = $this->head;

        // Loop until the end of the list. The $current value could be null
        // or it may have a null value for the next value, so do some
        // null coalesce here to prevent errors.
        while (($current->next ?? null) !== null) {
            // If the next node's bidId is the same as the bidId passed in
            // then we should execute this block of code to remove the
            // node from the list.
            if (strcmp($current->next->bid->bidId, $bidId) === 0) {
                // Create a temp node variable that references the next node in the list
                $tempNode = $current->next;

                // We're looking one ahead here, so we want to set the current node's
                // `next` to be the next's `next` so that we can remove the actual next node.
                $current->next = $tempNode->next;

                // Remove the next node
                unset($tempNode);

                // Decrement the size of the list
                $this->size--;

                // Bail out of the loop and function since we found the node to remove
                return;
            }

            // Set the current to the next node so we can continue the loop
            $current = $current->next;
        }
    }

    /**
     * Search for the specified bidId
     *
     * @param string $bidId The bid ID to search for
     * @return Bid|null Returns a Bid if found and null if not found
     */
    public function search(string $bidId): ?Bid
    {
        // Create a current node variable that initializes to the head of the list
        $current = $this->head;

        // Loop through all nodes in the list until we hit a null value
        while ($current !== null) {
            // If the current bid's bidId matches the one passed in, return the
            // current bid (returning here exits the loop so we don't waste cycles).
            if (strcmp($current->bid->bidId, $bidId) === 0) {
                return $current->bid;
            }

            // Set the current variable to the next node so we can continue the loop
            $current = $current->next;
        }

        // If the code reaches this part it means no matching bid was found.
        // Return a null value here to indicate no bid was found.
        return null;
    }

    /**
     * Returns the current size (number of elements) in the list
     *
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }
}