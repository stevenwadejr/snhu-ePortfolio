//============================================================================
// Name        : VectorSorting.cpp
// Author      : Steven Wade
// Course      : CS-260-J3567 Data Structures and Algorithms 20EW3
// Date        : 2020-02-02
// Project     : 4-2 Programming Activity: Queues, Stacks, and Sorting
// Version     : 1.0
// Copyright   : Copyright © 2017 SNHU COCE
// Description : Vector Sorting Algorithms
//============================================================================

#include <algorithm>
#include <iostream>
#include <time.h>

#include "CSVparser.hpp"

using namespace std;

//============================================================================
// Global definitions visible to all methods and classes
//============================================================================

// forward declarations
double strToDouble(string str, char ch);

// define a structure to hold bid information
struct Bid
{
    string bidId; // unique identifier
    string title;
    string fund;
    double amount;
    Bid()
    {
        amount = 0.0;
    }
};

//============================================================================
// Static methods used for testing
//============================================================================

/**
 * Display the bid information to the console (std::out)
 *
 * @param bid struct containing the bid info
 */
void displayBid(Bid bid)
{
    cout << bid.bidId << ": " << bid.title << " | " << bid.amount << " | "
         << bid.fund << endl;
    return;
}

/**
 * Prompt user for bid information using console (std::in)
 *
 * @return Bid struct containing the bid info
 */
Bid getBid()
{
    Bid bid;

    cout << "Enter Id: ";
    cin.ignore();
    getline(cin, bid.bidId);

    cout << "Enter title: ";
    getline(cin, bid.title);

    cout << "Enter fund: ";
    cin >> bid.fund;

    cout << "Enter amount: ";
    cin.ignore();
    string strAmount;
    getline(cin, strAmount);
    bid.amount = strToDouble(strAmount, '$');

    return bid;
}

/**
 * Load a CSV file containing bids into a container
 *
 * @param csvPath the path to the CSV file to load
 * @return a container holding all the bids read
 */
vector<Bid> loadBids(string csvPath)
{
    cout << "Loading CSV file " << csvPath << endl;

    // Define a vector data structure to hold a collection of bids.
    vector<Bid> bids;

    // initialize the CSV Parser using the given path
    csv::Parser file = csv::Parser(csvPath);

    try
    {
        // loop to read rows of a CSV file
        for (int i = 0; i < file.rowCount(); i++)
        {

            // Create a data structure and add to the collection of bids
            Bid bid;
            bid.bidId = file[i][1];
            bid.title = file[i][0];
            bid.fund = file[i][8];
            bid.amount = strToDouble(file[i][4], '$');

            //cout << "Item: " << bid.title << ", Fund: " << bid.fund << ", Amount: " << bid.amount << endl;

            // push this bid to the end
            bids.push_back(bid);
        }
    }
    catch (csv::Error &e)
    {
        std::cerr << e.what() << std::endl;
    }
    return bids;
}

/**
 * Partition the vector of bids into two parts, low and high
 *
 * @param bids Address of the vector<Bid> instance to be partitioned
 * @param begin Beginning index to partition
 * @param end Ending index to partition
 */
int partition(vector<Bid> &bids, int begin, int end)
{
    // Initialize variables to represent the low value and high
    int low = begin;
    int high = end;

    // Create a pivot point that is in between the beginning and the end points
    int pivot = begin + (end - begin) / 2;

    // Determine whether the loop is done or not
    bool done = false;

    // Loop until done
    while (!done)
    {
        // Loop through the bids comparing the lower half of the list with the pivot
        while (bids.at(low).title.compare(bids.at(pivot).title) < 0)
        {
            ++low;
        }

        // Loop through the bids comparing the upper half of the list with the pivot
        while (bids.at(pivot).title.compare(bids.at(high).title) < 0)
        {
            --high;
        }

        // If we've reached the midway point then we're done
        if (low >= high)
        {
            done = true;
        }
        else
        {
            // If we aren't midway then swap the two bids at the low and high points
            swap(bids.at(low), bids.at(high));

            ++low;
            --high;
        }
    }

    return high;
}

/**
 * Perform a quick sort on bid title
 * Average performance: O(n log(n))
 * Worst case performance O(n^2))
 *
 * @param bids address of the vector<Bid> instance to be sorted
 * @param begin the beginning index to sort on
 * @param end the ending index to sort on
 */
void quickSort(vector<Bid> &bids, int begin, int end)
{
    int mid = 0;

    // If there's only one element then the list is already sorted
    if (begin >= end)
    {
        return;
    }

    // Find the partition, or midway point, between the beginning and the end.
    mid = partition(bids, begin, end);

    // Recursively sort the lower half (beginning to the midway point)
    quickSort(bids, begin, mid);

    // Recursively sort the upper half (midway plus one to the end point)
    quickSort(bids, mid + 1, end);

    return;
}

/**
 * Perform a selection sort on bid title
 * Average performance: O(n^2))
 * Worst case performance O(n^2))
 *
 * @param bid address of the vector<Bid>
 *            instance to be sorted
 */
void selectionSort(vector<Bid> &bids)
{
    // Create an int to store the smallest found index
    int smallestIndex;

    // Loop through the list of bids to then find and compare the titles
    for (int outerPos = 0; outerPos < bids.size(); ++outerPos)
    {

        // The smallest index starts with the index position of the outer loop.
        // For each iteration of the outer loop this index will move one place closer
        // to the end of the bids list.
        smallestIndex = outerPos;

        // Loop through all items starting after the current item in the outer loop
        for (int innerPos = outerPos + 1; innerPos < bids.size(); ++innerPos)
        {
            // Compare the titles, if the title found is smaller (comes alphabetically before
            // the outer loop's title), then this bid's index is now the smallest.
            if (bids.at(innerPos).title.compare(bids.at(smallestIndex).title) < 0)
            {
                smallestIndex = innerPos;
            }
        }

        // Check to see if a smaller index has been found
        if (smallestIndex != outerPos)
        {
            // Swap the bid in the outer loop with the one found to be alphabetically first
            swap(bids.at(outerPos), bids.at(smallestIndex));
        }
    }
}

/**
 * Simple C function to convert a string to a double
 * after stripping out unwanted char
 *
 * credit: http://stackoverflow.com/a/24875936
 *
 * @param ch The character to strip out
 */
double strToDouble(string str, char ch)
{
    str.erase(remove(str.begin(), str.end(), ch), str.end());
    return atof(str.c_str());
}

/**
 * The one and only main() method
 */
int main(int argc, char *argv[])
{

    // process command line arguments
    string csvPath;
    switch (argc)
    {
    case 2:
        csvPath = argv[1];
        break;
    default:
        csvPath = "eBid_Monthly_Sales_Dec_2016.csv";
    }

    // Define a vector to hold all the bids
    vector<Bid> bids;

    // Define a timer variable
    clock_t ticks;

    int choice = 0;
    while (choice != 9)
    {
        cout << "Menu:" << endl;
        cout << "  1. Load Bids" << endl;
        cout << "  2. Display All Bids" << endl;
        cout << "  3. Selection Sort All Bids" << endl;
        cout << "  4. Quick Sort All Bids" << endl;
        cout << "  9. Exit" << endl;
        cout << "Enter choice: ";
        cin >> choice;

        switch (choice)
        {

        case 1:
            // Initialize a timer variable before loading bids
            ticks = clock();

            // Complete the method call to load the bids
            bids = loadBids(csvPath);

            cout << bids.size() << " bids read" << endl;

            // Calculate elapsed time and display result
            ticks = clock() - ticks; // current clock ticks minus starting clock ticks
            cout << "time: " << ticks << " clock ticks" << endl;
            cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;

            break;

        case 2:
            // Loop and display the bids read
            for (int i = 0; i < bids.size(); ++i)
            {
                displayBid(bids[i]);
            }
            cout << endl;

            break;

        case 3:
            // Initialize a timer variable before loading bids
            ticks = clock();

            // Perform a selection sort on the bids
            selectionSort(bids);

            // Calculate elapsed time and display result
            ticks = clock() - ticks; // current clock ticks minus starting clock ticks
            cout << "time: " << ticks << " clock ticks" << endl;
            cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;
            break;

        case 4:
            // Initialize a timer variable before loading bids
            ticks = clock();

            // Perform a quick sort on the bids
            quickSort(bids, 0, bids.size() - 1);

            // Calculate elapsed time and display result
            ticks = clock() - ticks; // current clock ticks minus starting clock ticks
            cout << "time: " << ticks << " clock ticks" << endl;
            cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;
            break;
        }
    }

    cout << "Good bye." << endl;

    return 0;
}
