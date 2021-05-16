//============================================================================
// Name        : LinkedList.cpp
// Author      : Steven Wade
// Course      : CS-260-J3567 Data Structures and Algorithms 20EW3
// Date        : 2020-01-26
// Project     : 3-2 Programming Activity: Lists and Searching
// Version     : 1.0
// Copyright   : Copyright © 2017 SNHU COCE
// Description : Lab 3-3 Lists and Searching
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
struct Bid {
    string bidId; // unique identifier
    string title;
    string fund;
    double amount;
    Bid() {
        amount = 0.0;
    }
};

//============================================================================
// Linked-List class definition
//============================================================================

/**
 * Define a class containing data members and methods to
 * implement a linked-list.
 */
class LinkedList {

private:
    /**
     * Define an internal structure for a "Node". Each Node will
     * store a Bid and a pointer to the next Node. The structure
     * contains two constructors: one to set `next` to a null
     * pointer and a second one to accept a Bid and assign it
     * internally.
     */
	struct Node {
		Bid bid;
		Node* next;

		Node() {
			next = nullptr;
		}

		Node(Bid newBid) {
			bid = newBid;
			next = nullptr;
		}
	};

	// Define Initial head and tail pointers, as well as a size of
	// this list to 0 as it contains nothing by default.
	Node* head;
	Node* tail;
	int size = 0;

public:
    LinkedList();
    virtual ~LinkedList();
    void Append(Bid bid);
    void Prepend(Bid bid);
    void PrintList();
    void Remove(string bidId);
    Bid Search(string bidId);
    int Size();
};

/**
 * Default constructor
 */
LinkedList::LinkedList() {
    // Set the head and tail pointers to null pointers by default
	head = nullptr;
	tail = nullptr;
}

/**
 * Destructor
 *
 * This program doesn't create multiple linked lists or destroy lists
 * so there's no point to do any cleanup in the destructor as the memory
 * will free up when the program exits.
 */
LinkedList::~LinkedList() {
}

/**
 * Append a new bid to the end of the list
 */
void LinkedList::Append(Bid bid) {
	// Create a new Node pointer with the passed in Bid
	Node* newNode = new Node(bid);

	// If the head of the list is a null pointer, then this new node
	// should be promoted to the head
    if (head == nullptr) {
    	head = newNode;
    } else if (tail != nullptr) {
    	// If the tail isn't a null pointer, we're going to update the
    	// tail's `next` pointer to be the new node.
    	tail->next = newNode;
    }

    // Since we're appending this to the list, always make the new node the tail
    tail = newNode;

    // Increment the size of this list
    size++;
}

/**
 * Prepend a new bid to the start of the list
 */
void LinkedList::Prepend(Bid bid) {
	// Create a new Node pointer with the passed in Bid
    Node* newNode = new Node(bid);

    // If the head of the list isn't a null pointer (meaning a head
    // already exists), then set the new node's `next` pointer to
    // the current head.
    if (head != nullptr) {
    	newNode->next = head;
    }

    // Since we're prepending, the new node will always be the head of the list
    head = newNode;

    // Increment the size of this list
    size++;
}

/**
 * Simple output of all bids in the list
 */
void LinkedList::PrintList() {
    // Create a current pointer that initializes to that of the list's head
	Node* current = head;

	// Do this loop while the current pointer isn't a null pointer.
	while (current != nullptr) {
		// Print the bid ID, title, amount, and the fund.
		cout << current->bid.bidId << ": " << current->bid.title << " | "
				<< current->bid.amount << " | " << current->bid.fund << endl;

		// Set the current pointer to that of the next in order to continue the loop
		current = current->next;
	}
}

/**
 * Remove a specified bid
 *
 * @param bidId The bid id to remove from the list
 */
void LinkedList::Remove(string bidId) {
    // Two checks here:
	//   1) If the head isn't a null pointer (head is a valid Node)
	//   2) AND, the head's Bid bidId is equal to the passed in bidId
	// If these two conditions are met, that means the bid that we want
	// to remove is the head of the list.
	if (head != nullptr && head->bid.bidId.compare(bidId) == 0) {
		// Create a temporary pointer node that points to the head's next value
		Node* tempNode = head->next;

		// Delete the head
		delete head;

		// Now, reset the head of the list to the temp node (the second one in
		// in the list - head->next).
		head = tempNode;

		// Decrement the size of the list
		size--;

		// Bail early since we found our match and removed it.
		return;
	}

	// Create a pointer node that points to the current place in the list -
	// starting with the head.
	Node* current = head;

	// Loop until the end of the list
	while (current->next != nullptr) {
		// If the next node's bidId is the same as the bidId passed in
		// then we should execute this block of code to remove the node from the list.
		if (current->next->bid.bidId.compare(bidId) == 0) {
			// Create a temp node pointer that references the next node in the list
			Node* tempNode = current->next;

			// We're looking one ahead here, so we want to set the current node's
			// `next` to be the next's `next` so that we can remove the actual next node.
			current->next = tempNode->next;

			// Remove the next node
			delete tempNode;

			// Decrement the size of the list
			size--;

			// Bail out of the loop and function since we found the node to remove
			return;
		}

		// Set the current to the next node so we can continue the loop
		current = current->next;
	}
}

/**
 * Search for the specified bidId
 *
 * @param bidId The bid id to search for
 */
Bid LinkedList::Search(string bidId) {
    // Create a current node pointer that initializes to the head of the list
	Node* current = head;

	// Loop through all nodes in the list until we hit a null pointer
	while (current != nullptr) {
		// If the current bid's bidId matches the one passed in, return the
		// current bid (returning here exits the loop so we don't waste cycles).
		if (current->bid.bidId.compare(bidId) == 0) {
			return current->bid;
		}
		// Set the current to the next node so we can continue the loop.
		current = current->next;
	}

	// Create an empty Bid and return it. This is in case the bid wasn't found
	// then we can at least return an empty one to be compared later in the code.
	Bid bid;
	return bid;
}

/**
 * Returns the current size (number of elements) in the list
 */
int LinkedList::Size() {
    return size;
}

//============================================================================
// Static methods used for testing
//============================================================================

/**
 * Display the bid information
 *
 * @param bid struct containing the bid info
 */
void displayBid(Bid bid) {
    cout << bid.bidId << ": " << bid.title << " | " << bid.amount
         << " | " << bid.fund << endl;
    return;
}

/**
 * Prompt user for bid information
 *
 * @return Bid struct containing the bid info
 */
Bid getBid() {
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
 * Load a CSV file containing bids into a LinkedList
 *
 * @return a LinkedList containing all the bids read
 */
void loadBids(string csvPath, LinkedList *list) {
    cout << "Loading CSV file " << csvPath << endl;

    // initialize the CSV Parser
    csv::Parser file = csv::Parser(csvPath);

    try {
        // loop to read rows of a CSV file
        for (int i = 0; i < file.rowCount(); i++) {

            // initialize a bid using data from current row (i)
            Bid bid;
            bid.bidId = file[i][1];
            bid.title = file[i][0];
            bid.fund = file[i][8];
            bid.amount = strToDouble(file[i][4], '$');

            // add this bid to the end
            list->Append(bid);
        }
    } catch (csv::Error &e) {
        std::cerr << e.what() << std::endl;
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
double strToDouble(string str, char ch) {
    str.erase(remove(str.begin(), str.end(), ch), str.end());
    return atof(str.c_str());
}

/**
 * The one and only main() method
 *
 * @param arg[1] path to CSV file to load from (optional)
 * @param arg[2] the bid Id to use when searching the list (optional)
 */
int main(int argc, char* argv[]) {

    // process command line arguments
    string csvPath, bidKey;
    switch (argc) {
    case 2:
        csvPath = argv[1];
        bidKey = "98109";
        break;
    case 3:
        csvPath = argv[1];
        bidKey = argv[2];
        break;
    default:
        csvPath = "eBid_Monthly_Sales_Dec_2016.csv";
        bidKey = "98109";
    }

    clock_t ticks;

    // A linked list to hold the bids
    LinkedList bidList;

    // The current bid - defaults to an empty one
    Bid bid;

    int choice = 0;
    while (choice != 9) {
        cout << "Menu:" << endl;
        cout << "  1. Enter a Bid" << endl;
        cout << "  2. Load Bids" << endl;
        cout << "  3. Display All Bids" << endl;
        cout << "  4. Find Bid" << endl;
        cout << "  5. Remove Bid" << endl;
        cout << "  9. Exit" << endl;
        cout << "Enter choice: ";
        cin >> choice;

        switch (choice) {
        case 1:
            bid = getBid();
            bidList.Append(bid);
            displayBid(bid);

            break;

        case 2:
            ticks = clock();

            // Load the bids from the given CSV path into the linked list of bids.
            // Pass the bid list in by reference in order to use the same list declared
            // above and load the bids into it.
            loadBids(csvPath, &bidList);

            // Print the size of the list
            cout << bidList.Size() << " bids read" << endl;

            // Display the amount of time it took to load the bids
            ticks = clock() - ticks; // current clock ticks minus starting clock ticks
            cout << "time: " << ticks << " milliseconds" << endl;
            cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;

            break;

        case 3:
        	// Loop through all bids and print them - done internally within the linked list
            bidList.PrintList();

            break;

        case 4:
            ticks = clock();

            // Search the list for the bid matching the bid ID
            bid = bidList.Search(bidKey);

            ticks = clock() - ticks; // current clock ticks minus starting clock ticks

            // If the bid returned isn't empty, then display the bid, else show that
            // it was not found in the list.
            if (!bid.bidId.empty()) {
                displayBid(bid);
            } else {
            	cout << "Bid Id " << bidKey << " not found." << endl;
            }

            // Display the amount of processing time it took to search the list
            cout << "time: " << ticks << " clock ticks" << endl;
            cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;

            break;

        case 5:
        	// Remove the current bid from the list based on its ID
            bidList.Remove(bidKey);

            break;
        }
    }

    cout << "Good bye." << endl;

    return 0;
}
