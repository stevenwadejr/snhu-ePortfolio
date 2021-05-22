<?php


namespace stevenwadejr\hash;


use Iterator;
use League\Csv\Reader;
use League\Csv\ResultSet;
use stevenwadejr\Bid;
use stevenwadejr\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class HashTableCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('Runs the hash table program')
            ->addArgument('bidKey', InputArgument::OPTIONAL, 'ID of the bid to search for', '98109');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $choice = 0;

        /** @var HashTable|null $bidTable */
        $bidTable = null;
        $bidKey = $input->getArgument('bidKey');

        while ($choice != 9) {
            $output->writeln(
                [
                    'Menu:',
                    '  1. Load Bids',
                    '  2. Display All Bids',
                    '  3. Find Bid',
                    '  4. Remove Bid',
                    '  5. Count Nodes',
                    '  9. Exit',
                ]
            );

            $helper = $this->getHelper('question');
            $question = new Question('Enter choice: ');
            $choice = $helper->ask($input, $output, $question);

            switch ($choice) {
                case 1:

                    // Initialize a timer variable before loading bids
                    $start = microtime(true);

                    // Complete the method call to load the bids
                    $this->loadBids(
                        function (Bid $bid) use (&$bidTable) {
                            $bidTable->insert($bid);
                        },
                        function (Reader $reader, ResultSet $resultSet) use (&$bidTable) {
                            $bidTable = new HashTable($resultSet->count());
                        }
                    );

                    // Calculate elapsed time and display result
                    $end = microtime(true);
                    $executionTime = $end - $start;
                    $output->writeln('time: ' . $executionTime . ' seconds');
                    break;

                case 2:
                    if ($bidTable === null) {
                        $output->writeln('<comment>No bids loaded</comment>');
                        break;
                    }

                    foreach ($bidTable->printAll() as $response) {
                        $output->writeln($response);
                    }

                    break;

                case 3:
                    if ($bidTable === null) {
                        $output->writeln('<comment>No bids loaded</comment>');
                        break;
                    }

                    $start = microtime(true);

                    $bid = $bidTable->search($bidKey);

                    $end = microtime(true);
                    $executionTime = $end - $start;

                    if (!empty($bid)) {
                        $this->displayBid($bid);
                    } else {
                        $output->writeln('<comment>Bid Id ' . $bidKey . ' not found.</comment>');
                    }

                    $output->writeln('time: ' . $executionTime . ' seconds');

                    break;

                case 4:
                    if ($bidTable === null) {
                        $output->writeln('<comment>No bids loaded</comment>');
                        break;
                    }

                    $bidTable->remove($bidKey);
                    break;
                case 5:
                    if ($bidTable === null) {
                        $output->writeln('<comment>No bids loaded</comment>');
                        break;
                    }

                    $output->writeln('Nodes count = ' . $bidTable->countNodes());
                    break;
            }
        }

        $output->writeln('Good bye.');

        return Command::SUCCESS;
    }
}