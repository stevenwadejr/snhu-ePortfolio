<?php

namespace stevenwadejr;

use Closure;
use Exception;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    protected InputInterface $input;

    protected OutputInterface $output;

    /**
     * Override the parent run command to catch an exceptions that happen and
     * report them to the user and then return a failure code.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        try {
            return parent::run($input, $output);
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            return parent::FAILURE;
        }
    }

    /**
     * Configure the default arguments shared by child commands
     */
    protected function configure()
    {
        $this->addArgument(
            'csvFile',
            InputArgument::OPTIONAL,
            'CSV of bids to load',
            'eBid_Monthly_Sales_Dec_2016.csv'
        );
    }

    /**
     * Override the parent function in order to cache the input and output
     * variables to the class so they can be used within the `loadBids` method.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        parent::initialize($input, $output);
    }

    /**
     * Load a CSV file containing bids.
     *
     * @param Closure $rowCallback
     * @param Closure|null $onCsvReadCallback
     * @throws \League\Csv\UnableToProcessCsv
     */
    protected function loadBids(Closure $rowCallback, Closure $onCsvReadCallback = null)
    {
        $csvFile = $this->input->getArgument('csvFile');
        $csvPath = $this->getApplication()->getAppDir() . '/' . $csvFile;

        // Ensure the CSV file exists before trying to load it
        if (!file_exists($csvPath)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'CSV file %s not found in %s',
                    $csvFile,
                    $this->getApplication()->getAppDir()
                )
            );
        }

        $this->output->writeln('Loading CSV file ' . $csvFile);

        // Load the CSV file
        $reader = Reader::createFromPath($csvPath, 'r');

        // Load the headers and remove extra whitespace
        $headers = array_map('trim', $reader->fetchOne(0));

        $this->output->writeln(implode(' | ', $headers));

        // Create a result set starting with the first row after the header row.
        //
        // Use this method instead of setting a header offset so we can
        // keep the integer indexes instead of converting records to an
        // associative array as headers change from CSV to CSV, but the
        // indexes are the same for each file.
        $resultSet = Statement::create()->offset(1)->process($reader);

        // If a callback was provided for when reading the CSV, call it
        if ($onCsvReadCallback) {
            $onCsvReadCallback($reader, $resultSet);
        }

        // Loop through each row and create a new bid
        foreach ($resultSet->getRecords() as $record) {
            $bid = new Bid();
            $bid->bidId = $record[1];
            $bid->title = $record[0];
            $bid->fund = $record[8];
            $bid->amount = $this->stringToDouble($record[4]);

            // Pass the new bid to the row callback function. Each implementation
            // will handle bids differently so let them decide by using a callback.
            $rowCallback($bid);
        }
    }

    /**
     * Helper function to print a bid to the screen
     *
     * @param Bid $bid
     */
    protected function displayBid(Bid $bid): void
    {
        // Use the `write` method here instead of `writeln` in order to write the format
        // easier by passing in each piece as an array element. Finish the string off
        // with a newline character.
        $this->output->write(
            [
                '<info>',
                $bid->bidId,
                ': ',
                $bid->title,
                ' | ',
                $bid->amount,
                ' | ',
                $bid->fund,
                '</info>',
                PHP_EOL
            ]
        );
    }

    /**
     * Helper function to parse a float from a string
     *
     * @param string $str
     * @return float
     */
    protected function stringToDouble(string $str): float
    {
        return number_format(
            floatval(preg_replace('/[^-0-9\.]/', '', $str)),
            2,
            '.',
            ''
        );
    }
}