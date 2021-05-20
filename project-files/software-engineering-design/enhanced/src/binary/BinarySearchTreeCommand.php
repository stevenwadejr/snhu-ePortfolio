<?php

namespace stevenwadejr\binary;

use stevenwadejr\Bid;
use stevenwadejr\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class BinarySearchTreeCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('Runs the binary search tree program')
            ->addArgument('bidKey', InputArgument::OPTIONAL, 'ID of the bid to search for', '98109');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $choice = 0;
        $bst = null;
        $bidKey = $input->getArgument('bidKey');

        while ($choice != 9) {
            $output->writeln(
                [
                    'Menu:',
                    '  1. Load Bids',
                    '  2. Display All Bids',
                    '  3. Find Bid',
                    '  4. Remove Bid',
                    '  9. Exit',
                ]
            );

            $helper = $this->getHelper('question');
            $question = new Question('Enter choice: ');
            $choice = $helper->ask($input, $output, $question);

            switch ($choice) {
                case 1:
                    $bst = new BinarySearchTree();

                    // Initialize a timer variable before loading bids
                    $start = microtime(true);

                    // Complete the method call to load the bids
                    $this->loadBids(
                        function (Bid $bid) use ($bst) {
                            $bst->insert($bid);
                        }
                    );

                    $output->writeln($bst->size() . ' bids read');

                    // Calculate elapsed time and display result
                    $end = microtime(true);
                    $executionTime = $end - $start;
                    $output->writeln('time: ' . $executionTime . ' seconds');
                    break;

                case 2:
                    if ($bst === null) {
                        $output->writeln('<comment>No bids loaded</comment>');
                        break;
                    }

                    $bst->inOrder();
                    break;

                case 3:
                    if ($bst === null) {
                        $output->writeln('<comment>No bids loaded</comment>');
                        break;
                    }

                    $start = microtime(true);

                    $bid = $bst->search($bidKey);

                    $end = microtime(true);
                    $executionTime = $end - $start;

                    if (!empty($bid->bidId)) {
                        $this->displayBid($bid);
                    } else {
                        $output->writeln('<comment>Bid Id ' . $bidKey . ' not found.</comment>');
                    }

                    $output->writeln('time: ' . $executionTime . ' seconds');

                    break;

                case 4:
                    if ($bst === null) {
                        $output->writeln('<comment>No bids loaded</comment>');
                        break;
                    }

                    $bst->remove($bidKey);
                    break;
            }
        }

        return Command::SUCCESS;
    }
}