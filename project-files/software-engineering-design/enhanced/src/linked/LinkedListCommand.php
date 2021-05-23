<?php

namespace stevenwadejr\linked;

use stevenwadejr\Bid;
use stevenwadejr\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class LinkedListCommand extends Command
{
    protected function configure(): void
    {
        parent::configure();
        $this
            ->setDescription('Runs the linked list program')
            ->addArgument('bidKey', InputArgument::OPTIONAL, 'ID of the bid to search for', '98109');
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

        // Create a linked list variable
        $bidList = new LinkedList();

        // Read the bid key argument from the user's command line input
        $bidKey = $input->getArgument('bidKey');

        // Run the program until the user requests to exit
        while ($choice != 9) {
            // Print the menu
            $output->writeln(
                [
                    'Menu:',
                    '  1. Enter a bid',
                    '  2. Load Bids',
                    '  3. Display All Bids',
                    '  4. Find Bid',
                    '  5. Remove Bid',
                    '  9. Exit',
                ]
            );

            // Prompt the user to make a menu selection and store the response in the $choice variable
            $helper = $this->getHelper('question');
            $choice = $helper->ask($input, $output, new Question('Enter choice: '));

            switch ($choice) {
                case 1: // Create bids manually
                    // Let the user create a bid manually
                    $bid = $this->getBid($input, $output);

                    // Ask the user whether they want to prepend or append the bid to the list
                    // The `ChoiceQuestion` class will prevent invalid answers. Defaults to the end.
                    $question = new ChoiceQuestion(
                        'Insert the bid at the beginning or end?',
                        ['b' => 'Beginning', 'e' => 'End'],
                        'e'
                    );

                    // Determine the direction the user entered
                    $direction = strtolower($helper->ask($input, $output, $question));

                    // Append or prepend to the list depending on the user's selection
                    if ($direction === 'e') {
                        $bidList->append($bid);
                    } else {
                        $bidList->prepend($bid);
                    }

                    $this->displayBid($bid);

                    break;
                case 2: // Load bids

                    // Initialize a timer variable before loading bids
                    $start = microtime(true);

                    // Complete the method call to load the bids
                    $this->loadBids(
                        function (Bid $bid) use (&$bidList) {
                            $bidList->append($bid);
                        }
                    );

                    $output->writeln($bidList->size() . ' bids read');

                    // Calculate elapsed time and display result
                    $end = microtime(true);
                    $executionTime = $end - $start;
                    $output->writeln('time: ' . $executionTime . ' seconds');

                    break;
                case 3: // Display all bids

                    // Write each line from the list to the console
                    foreach ($bidList->printList() as $response) {
                        $output->writeln($response);
                    }

                    break;
                case 4: // Search for a bid

                    $start = microtime(true);

                    $bid = $bidList->search($bidKey);

                    $end = microtime(true);
                    $executionTime = $end - $start;

                    if (!empty($bid)) {
                        $this->displayBid($bid);
                    } else {
                        $output->writeln('<comment>Bid Id ' . $bidKey . ' not found.</comment>');
                    }

                    $output->writeln('time: ' . $executionTime . ' seconds');

                    break;
                case 5: // Remove a bid

                    $bidList->remove($bidKey);

                    break;
            }
        }

        $output->writeln('Good bye.');

        return Command::SUCCESS;
    }

    /**
     * Prompt user for bid information
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return Bid
     */
    protected function getBid(InputInterface $input, OutputInterface $output): Bid
    {
        $helper = $this->getHelper('question');
        $bid = new Bid();

        $bid->bidId = $helper->ask($input, $output, new Question('Enter Id: '));
        $bid->title = $helper->ask($input, $output, new Question('Enter title: '));
        $bid->fund = $helper->ask($input, $output, new Question('Enter fund: '));
        $bid->amount = $this->stringToDouble(
            $helper->ask($input, $output, new Question('Enter amount: '))
        );

        return $bid;
    }
}