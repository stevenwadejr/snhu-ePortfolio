<?php

namespace stevenwadejr\sorting;

use stevenwadejr\Bid;

class Sorter
{
    /**
     * @var Bid[]
     */
    private array $bids = [];

    /**
     * Flag to determine if the bids are ready for sorting (ie: haven't already been sorted)
     *
     * @var bool
     */
    private bool $ready = true;

    public function addBid(Bid $bid): void
    {
        $this->bids[] = $bid;
    }

    public function getBids(): array
    {
        return $this->bids;
    }

    public function totalBids(): int
    {
        return count($this->bids);
    }

    /**
     * Shuffles the bids array to ensure each sorting function operates on a random order
     */
    public function reset(): void
    {
        if (!$this->ready) {
            shuffle($this->bids);
            $this->ready = true;
        }
    }

    /**
     * Partition the array of bids into two parts, low and high
     *
     * @param int $begin Beginning index to partition
     * @param int $end Ending index to partition
     * @return int
     */
    public function partition(int $begin, int $end): int
    {
        // Initialize variables to represent the low value and high
        $low = $begin;
        $high = $end;

        // Create a pivot point that is in between the beginning and the end points
        $pivot = $begin + ($end - $begin) / 2;

        // Flag to determine whether the loop is done or not
        $done = false;

        // Loop until done
        while (!$done) {
            // Loop through the bids comparing the lower half of the list with the pivot
            while (strcmp($this->bids[$low]->title, $this->bids[$pivot]->title) < 0) {
                ++$low;
            }

            // Loop through the bids comparing the upper half of the list with the pivot
            while (strcmp($this->bids[$pivot]->title, $this->bids[$high]->title) < 0) {
                --$high;
            }

            // If we've reached the midway point, then we're done
            if ($low >= $high) {
                $done = true;
            } else {
                // If we aren't midway, then swap the two bids at the low and high points
                $newLow = $this->bids[$high];
                $newHigh = $this->bids[$low];

                $this->bids[$low] = $newLow;
                $this->bids[$high] = $newHigh;

                ++$low;
                --$high;

                unset($newLow, $newHigh);
            }
        }

        return $high;
    }

    /**
     * Perform a quick sort on bid title
     * Average performance: O(n log(n))
     * Worst case performance O(n^2))
     *
     * @param int $begin the beginning index to sort on
     * @param int $end the ending index to sort on
     */
    public function quickSort(int $begin, int $end): void
    {
        // If there's only one element then the list is already sorted
        if ($begin >= $end) {
            return;
        }

        // Find the partition, or midway point, between the beginning and the end.
        $mid = $this->partition($begin, $end);

        // Recursively sort the lower half (beginning to the midway point)
        $this->quickSort($begin, $mid);

        // Recursively sort the upper half (midway plus one to the end point)
        $this->quickSort($mid + 1, $end);

        $this->ready = false;
    }

    public function selectionSort(): void
    {
        $numberOfBids = $this->totalBids();

        // Loop through the list of bids to then find and compare the titles
        for ($outerPos = 0; $outerPos < $numberOfBids; ++$outerPos) {
            // The smallest index starts with the index position of the outer loop.
            // For each iteration of the outer loop this index will move one place closer
            // to the end of the bids list.
            $smallestIndex = $outerPos;

            // Loop through all items starting after the current item in the outer loop
            for ($innerPos = $outerPos + 1; $innerPos < $numberOfBids; ++$innerPos) {
                // Compare the titles, if the title found is smaller (comes alphabetically before
                // the outer loop's title), then this bid's index is now the smallest.
                if (strcmp($this->bids[$innerPos]->title, $this->bids[$smallestIndex]->title) < 0) {
                    $smallestIndex = $innerPos;
                }
            }

            // Check to see if a smaller index has been found
            if ($smallestIndex !== $outerPos) {
                $temp1 = $this->bids[$outerPos];
                $temp2 = $this->bids[$smallestIndex];

                $this->bids[$outerPos] = $temp2;
                $this->bids[$smallestIndex] = $temp1;

                unset($temp1, $temp2);
            }
        }

        $this->ready = false;
    }

    /**
     * Sort the bids array using PHP's native sorting function
     *
     */
    public function native(): void
    {
        usort(
            $this->bids,
            function (Bid $a, Bid $b) {
                return strcmp($a->title, $b->title);
            }
        );

        $this->ready = false;
    }
}