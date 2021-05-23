<?php

namespace stevenwadejr\sorting;

use stevenwadejr\Bid;
use stevenwadejr\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class SortingCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Runs the vector sorting program');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \League\Csv\UnableToProcessCsv
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Stores the user's menu choice
        $choice = 0;

        $sorter = new Sorter();

        // Run the program until the user requests to exit
        while ($choice != 9) {
            // Print the menu
            $output->writeln(
                [
                    'Menu:',
                    '  1. Load Bids',
                    '  2. Display All Bids',
                    '  3. Selection Sort All Bids',
                    '  4. Quick Sort All Bids',
                    '  5. Sort All Bids Using Native PHP Functions',
                    '  9. Exit',
                ]
            );

            // Prompt the user to make a menu selection and store the response in the $choice variable
            $helper = $this->getHelper('question');
            $choice = $helper->ask($input, $output, new Question('Enter choice: '));

            switch ($choice) {
                case 1: // Load bids

                    // Initialize a timer variable before loading bids
                    $start = microtime(true);

                    // Complete the method call to load the bids
                    $this->loadBids(
                        function (Bid $bid) use (&$sorter) {
                            $sorter->addBid($bid);
                        }
                    );

                    // Calculate elapsed time and display result
                    $end = microtime(true);
                    $executionTime = $end - $start;
                    $output->writeln('time: ' . $executionTime . ' seconds');

                    break;
                case 2: // Display all bids

                    foreach ($sorter->getBids() as $bid) {
                        $this->displayBid($bid, false);
                    }

                    break;
                case 3: // Selection Sort All Bids
                    // Ensure the bids are in a random order so we can
                    // accurately measure the sorting
                    $sorter->reset();

                    $start = microtime(true);

                    $sorter->selectionSort();

                    // Calculate elapsed time and display result
                    $end = microtime(true);
                    $executionTime = $end - $start;
                    $output->writeln('time: ' . $executionTime . ' seconds');

                    break;
                case 4: // Quick Sort All Bids
                    // Ensure the bids are in a random order so we can
                    // accurately measure the sorting
                    $sorter->reset();

                    // Initialize a timer variable before loading bids
                    $start = microtime(true);

                    $sorter->quickSort(0, $sorter->totalBids() - 1);

                    // Calculate elapsed time and display result
                    $end = microtime(true);
                    $executionTime = $end - $start;
                    $output->writeln('time: ' . $executionTime . ' seconds');

                    break;
                case 5: // Native PHP sorting with usort()
                    // Ensure the bids are in a random order so we can
                    // accurately measure the sorting
                    $sorter->reset();

                    // Initialize a timer variable before loading bids
                    $start = microtime(true);

                    $sorter->native();

                    // Calculate elapsed time and display result
                    $end = microtime(true);
                    $executionTime = $end - $start;
                    $output->writeln('time: ' . $executionTime . ' seconds');

                    break;
            }
        }

        $output->writeln('Good bye.');

        return Command::SUCCESS;
    }
}