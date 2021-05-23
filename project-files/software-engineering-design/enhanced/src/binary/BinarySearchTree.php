<?php

namespace stevenwadejr\binary;

use stevenwadejr\Bid;

class BinarySearchTree
{
    /**
     * @var Node|null The root node in the tree
     */
    public ?Node $root = null;

    /**
     * @var int Number of nodes in the tree
     */
    public int $size = 0;

    /**
     * Traverse the tree in order beginning with the root node
     */
    public function inOrder(): void
    {
        $this->_inOrder($this->root);
    }

    /**
     * Insert a Bid
     *
     * @param Bid $bid
     */
    public function insert(Bid $bid): void
    {
        // If the root isn't set, set it with a new node
        if ($this->root === null) {
            $this->root = new Node($bid);
        } else {
            // Add a new node to the tree starting at the root - the `addNode` will recursively
            // scan the tree and insert the bid where it needs to go.
            $this->addNode($this->root, $bid);
        }

        // Increment the size of the tree
        $this->size++;
    }

    /**
     * Remove a Bid by the given ID
     *
     * @param string $bidId The ID of the bid to remove
     */
    public function remove(string $bidId): void
    {
        // Start at the root node and search for the bid to remove
        $this->removeNode($this->root, $bidId);
    }

    /**
     * Search for a bid
     *
     * @param string $bidId The ID of the bid to search for
     * @return Bid|null Return the found Bid or null if none was found
     */
    public function search(string $bidId): ?Bid
    {
        // Point the current node to the root to start the search
        $current = $this->root;

        // Loop through until the current node is null
        while ($current !== null) {
            // Check to see if current node matches
            if (strcmp($current->bid->bidId, $bidId) === 0) {
                return $current->bid;
            }

            // Traverse the left subtree if less than, else check the right subtree
            $current = strcmp($bidId, $current->bid->bidId) < 0
                ? $current->left
                : $current->right;
        }

        // No bid was found, so return null
        return null;
    }

    /**
     * Return the size of the tree
     *
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * Add a bid to some node (recursive)
     *
     * @param Node $node Current node in the tree
     * @param Bid $bid Bid to be added
     */
    private function addNode(Node $node, Bid $bid): void
    {
        // If the new node is larger then then pass to the left subtree, else pass to the right
        $direction = strcmp($bid->bidId, $node->bid->bidId) < 0 ? 'left' : 'right';

        // If no subtree exists for the given direction, create a new subtree in that direction
        if ($node->$direction === null) {
            // Set the node's subtree to a new node
            $node->$direction = new Node($bid);
        } else {
            // A subtree in this direction exists, so we need
            // to recursively traverse it to insert it into the
            // correct position within that tree.
            $this->addNode($node->$direction, $bid);
        }
    }

    /**
     * Remove a node from the tree
     *
     * @param Node|null $node The beginning node to search
     * @param string $bidId The ID of the bid to remove
     * @return Node|null
     */
    private function removeNode(?Node $node, string $bidId): ?Node
    {
        // Bail if the node doesn't exist
        if ($node === null) {
            return null;
        }

        // Check the left subtree first
        if (strcmp($bidId, $node->bid->bidId) < 0) {
            // Set the node's left node to the value remainder of the tree
            // that's returned from removing the left's children
            $node->left = $this->removeNode($node->left, $bidId);

            // Our work is done, exit the function
            return $node;
        }

        // Check the right subtree
        if (strcmp($bidId, $node->bid->bidId) > 0) {
            // Set the node's right node to the value remainder of the tree
            // that's returned from removing the right's children
            $node->right = $this->removeNode($node->right, $bidId);

            // Our work is done, exit the function
            return $node;
        }

        // If this is a leaf node
        if ($node->left === null && $node->right === null) {
            // Setting the node to null will clear its value from memory
            $node = null;

            $this->size--;

        // One child to the left
        } elseif ($node->left !== null && $node->right === null) {
            // Overwrite the node with the value of the right subtree
            $node = $node->right;

            $this->size--;

        // One child to the right
        } elseif ($node->right !== null && $node->left === null) {
            // Overwrite the node with the value of the left subtree
            $node = $node->left;

            $this->size--;

        // Two children
        } else {
            // Create a temp node referencing/storing the right subtree
            $tempNode = $node->right;

            // Loop through the left subtree all the way down continuing left
            // to find the last instance of the left child
            while ($tempNode->left !== null) {
                $tempNode = $tempNode->left;
            }

            // Override the current node's bid with that of the last child's
            $node->bid = $tempNode->bid;

            // Overwrite the right subtree
            $node->right = $this->removeNode($node->right, $tempNode->bid->bidId);
        }

        return $node;
    }

    /**
     * Displays all Nodes in the subtrees of a given Node
     *
     * @param Node|null $node The Node to start displaying a tree/subtree from
     */
    private function _inOrder(?Node $node)
    {
        // Safety check to ensure we don't work on a null node
        if ($node === null) {
            return;
        }

        // Recursively traverse the left subtree to display its contents
        $this->_inOrder($node->left);

        // A node is found so let's display the bid
        echo $node->bid->bidId
            . ': '
            . $node->bid->title
            . ' | '
            . $node->bid->amount
            . ' | '
            . $node->bid->fund
            . PHP_EOL;

        // Recursively traverse the right subtree to display its contents
        $this->_inOrder($node->right);
    }
}