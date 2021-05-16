//============================================================================
// Name        : HashTable.cpp
// Author      : Steven Wade
// Course      : CS-260-J3567 Data Structures and Algorithms 20EW3
// Date        : 2020-02-02
// Project     : 5-2 Programming Activity: Hash Tables and Chaining
// Version     : 1.0
// Copyright   : Copyright © 2017 SNHU COCE
// Description : Hash table
//============================================================================

#include <algorithm>
#include <climits>
#include <iostream>
#include <string>
#include <time.h>

#include "CSVparser.hpp"

using namespace std;

//============================================================================
// Global definitions visible to all methods and classes
//============================================================================

const unsigned int DEFAULT_SIZE = 179;

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
// Hash Table class definition
//============================================================================

/**
 * Define a class containing data members and methods to
 * implement a hash table with chaining.
 */
class HashTable
{

private:
	// Create a Node structure to store the bid, the key, and a pointer to the next
	// node in the linked list (nodes that share a common key).
	struct Node
	{
		Bid bid;
		unsigned key;
		Node *next;

		// Initialize and set the key to a known value - in this instance, the max value that
		// an unsigned integer can be. Also set the next pointer to default to a null pointer.
		Node()
		{
			key = UINT_MAX;
			next = nullptr;
		}

		// Initialize with a bid only and call the parent constructor
		Node(Bid b) : Node()
		{
			bid = b;
		}

		// Initialize with a bid and a key while calling the parent constructor
		Node(Bid b, unsigned k) : Node(b)
		{
			key = k;
		}
	};

	// Create a vector to store the bid nodes
	vector<Node> nodes;

	// The default size of the vector table
	unsigned tableSize = DEFAULT_SIZE;

	// Private function to create a hash from a given key
	unsigned int hash(int key);

	// Private function that takes a bidId string and will return an integer key
	unsigned int hashFromBidId(string bidId);

public:
	HashTable();
	HashTable(unsigned size);
	virtual ~HashTable();
	void Insert(Bid bid);
	void PrintAll();
	void Remove(string bidId);
	Bid Search(string bidId);
	void CountNodes();
};

/**
 * Default constructor
 */
HashTable::HashTable()
{
	// Resize the vector to the table size
	nodes.resize(tableSize);
}

/**
 * Constructor with a size argument - this will be the size of the vector internally
 */
HashTable::HashTable(unsigned size)
{
	this->tableSize = size;
	nodes.resize(tableSize);
	cout << "Hash table size = " << tableSize << endl;
}

/**
 * Destructor
 */
HashTable::~HashTable()
{
	// Clear the internal vector and all of its nodes (free up memory)
	nodes.erase(nodes.begin());
}

/**
 * Calculate the hash value of a given key.
 * Note that key is specifically defined as
 * unsigned int to prevent undefined results
 * of a negative list index.
 *
 * @param key The key to hash
 * @return The calculated hash
 */
unsigned int HashTable::hash(int key)
{
	// Run a mod function on the key divided by the size of the table and return the remainder
	return key % tableSize;
}

/**
 * Helper method to convert a string bidId from a C++ String object
 * to a plain C string and parse an integer value from it. Then run the
 * hash function on that integer and return the hash value.
 *
 * @param bidId The string ID of the bid to convert and hash
 */
unsigned int HashTable::hashFromBidId(string bidId)
{
	return hash(atoi(bidId.c_str()));
}

/**
 * Insert a bid
 *
 * @param bid The bid to insert
 */
void HashTable::Insert(Bid bid)
{
	// Create a hashed key from the bid ID
	unsigned key = hashFromBidId(bid.bidId);

	// Find the address location of the node corresponding to the calculated key
	Node *oldNode = &(nodes.at(key));

	// If no node is found then we can insert a new one here
	if (oldNode == nullptr)
	{
		// Create a new node containing the bid and insert it into the nodes
		// vector with an offset value equal to the hashed key.
		Node *newNode = new Node(bid, key);
		nodes.insert(nodes.begin() + key, *newNode);
	}
	else
	{
		// If the found node has the max uint value for the key then we know that
		// it's a placeholder node and we need to update it's key and set the bid to make it
		// a valid bid node.
		if (oldNode->key == UINT_MAX)
		{
			// Set the key and bid, updating the next value to a null pointer for good measure.
			oldNode->key = key;
			oldNode->bid = bid;
			oldNode->next = nullptr;
		}
		else
		{
			// At this point there are more than one nodes in this chain so we need
			// to loop through them until we find the last one in the list.
			while (oldNode->next != nullptr)
			{
				// Just keep setting the old node to the next one so we can reach the end.
				oldNode = oldNode->next;
			}

			// Finally at the end of the list, create a new bid node and set it to the next
			// value on the last node in this keyed list.
			oldNode->next = new Node(bid, key);
		}
	}
}

/**
 * Print all bids
 */
void HashTable::PrintAll()
{
	// Loop through all of the indexes in the nodes list
	for (unsigned int i = 0; i < nodes.size(); i++)
	{
		// Find the address of the node at the current index
		Node *node = &(nodes.at(i));

		// If this address isn't a null pointer and the key does not equal the known uint max (meaning
		// that it isn't a placeholder node), then we should print it. This check will ignore placeholder
		// or null nodes.
		if (node != nullptr && node->key != UINT_MAX)
		{
			// Boolean value set to true on the first iteration of the loop so we can properly display "Key: " only once.
			bool isFirst = true;
			cout << "Key ";

			// Keep looping through all nodes in this chain
			while (node != nullptr)
			{
				// Create a temporary local variable set to the current node's bid.
				Bid bid = node->bid;

				// If this isn't the first item in the chain then we're going to prepend and pad the output
				// with enough spaces to line up under the parent "Key: ".
				cout << (!isFirst ? "    " : "");

				// Print out the bid's information
				cout << node->key << ": " << bid.bidId << " | " << bid.title << " | " << bid.amount << " | "
					 << bid.fund << endl;

				// Update to false to ensure prepending space padding on the front of the output.
				isFirst = false;

				// Set the current node to the next one (even if it's a nullpntr we're good since the loop will exit)
				node = node->next;
			}
		}
	}
	cout << endl;
}

/**
 * Remove a bid
 *
 * @param bidId The bid id to search for
 */
void HashTable::Remove(string bidId)
{
	// Create a hashed key from the bid ID string
	unsigned key = hashFromBidId(bidId);

	// Create a pointer node reference to the address of the current index within nodes.
	Node *node = &(nodes.at(key));

	// If the current node is a null pointer or the key is the known uint max then it's a
	// placeholder node and we should bail early from this function.
	if (node == nullptr || node->key == UINT_MAX)
	{
		return;
	}

	// Found at the head of the list
	if (node->bid.bidId.compare(bidId) == 0)
	{
		// Create a temp node pointing to the next node after this current one. This works because
		// even if there is no next, we're basically just creating a placeholder to take this one's
		// place in the same index of the nodes list.
		Node *tempNode = node->next;

		// Erase the entire node chain from the list. If you have 1->2->3 and we're erasing 1, then
		// 2 is now assigned to the tempNode, so down below when we insert it, we're reinserting
		// the chain/list 2->3 into the same position as this node within the list.
		nodes.erase(nodes.begin() + key);

		// Insert the temp node at the same position that we removed the head.
		nodes.insert(nodes.begin() + key, *tempNode);

		return;
	}

	Node *current = node;

	// Loop until the end of the list
	while (current->next != nullptr)
	{
		// If the next node's bidId is the same as the bidId passed in
		// then we should execute this block of code to remove the node from the list.
		if (current->next->bid.bidId.compare(bidId) == 0)
		{
			// Create a temp node pointer that references the next node in the list
			Node *tempNode = current->next;

			// We're looking one ahead here, so we want to set the current node's
			// `next` to be the next's `next` so that we can remove the actual next node.
			current->next = tempNode->next;

			// Remove the next node
			delete tempNode;

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
Bid HashTable::Search(string bidId)
{
	Bid bid;

	// Create a hashed key from the bid ID string value
	unsigned key = hashFromBidId(bidId);

	// Create a node pointer referencing the address of the index corresponding to the key
	Node *node = &(nodes.at(key));

	// No valid node found, only a placeholder or empty value - return the empty bid.
	if (node == nullptr || node->key == UINT_MAX)
	{
		return bid;
	}

	// If a valid node was found (not a null pointer or placeholder node), AND the bid ID matches
	// the one we're looking for, then return it.
	if (node != nullptr && node->key != UINT_MAX && node->bid.bidId.compare(bidId) == 0)
	{
		return node->bid;
	}

	// Now we've found a node and we have to loop through the chain
	while (node != nullptr)
	{
		// If it's not a placeholder node and the bid ID matches, return the bid.
		if (node->key != UINT_MAX && node->bid.bidId.compare(bidId) == 0)
		{
			return node->bid;
		}

		// Update the value of the node to the next node to keep the loop going.
		node = node->next;
	}

	return bid;
}

void HashTable::CountNodes()
{
	int count = 0;
	cout << "Nodes size = " << nodes.size() << endl;
	for (int i = 0; i < nodes.size(); ++i)
	{
		Node *node = &(nodes.at(i));
		if (node->key != UINT_MAX)
		{
			count++;
		}
	}
	cout << "Nodes count = " << count << endl;
}

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
 * Load a CSV file containing bids into a container
 *
 * @param csvPath the path to the CSV file to load
 * @return a container holding all the bids read
 */
void loadBids(string csvPath, HashTable* &hashTable)
{
	cout << "Loading CSV file " << csvPath << endl;

	// initialize the CSV Parser using the given path
	csv::Parser file = csv::Parser(csvPath);

	// Resize the table to be the same size as the number of rows
	// in the data. This will reduce the likelihood of collisions.
	hashTable = new HashTable(file.rowCount());

	// read and display header row - optional
	vector<string> header = file.getHeader();
	for (auto const &c : header)
	{
		cout << c << " | ";
	}
	cout << "" << endl;

	try
	{
		int count = 0;
		// loop to read rows of a CSV file
		for (unsigned int i = 0; i < file.rowCount(); i++)
		{

			// Create a data structure and add to the collection of bids
			Bid bid;
			bid.bidId = file[i][1];
			bid.title = file[i][0];
			bid.fund = file[i][8];
			bid.amount = strToDouble(file[i][4], '$');

			//cout << "Item: " << bid.title << ", Fund: " << bid.fund << ", Amount: " << bid.amount << endl;

			// push this bid to the end
			hashTable->Insert(bid);
			count++;
		}

		cout << count << " bids inserted" << endl;
	}
	catch (csv::Error &e)
	{
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
	string csvPath, searchValue;
	switch (argc)
	{
	case 2:
		csvPath = argv[1];
		searchValue = "98109";
		break;
	case 3:
		csvPath = argv[1];
		searchValue = argv[2];
		break;
	default:
		csvPath = "eBid_Monthly_Sales_Dec_2016.csv";
		searchValue = "98109";
	}

	// Define a timer variable
	clock_t ticks;

	// Define a hash table to hold all the bids
	HashTable *bidTable;

	Bid bid;

	int choice = 0;
	while (choice != 9)
	{
		cout << "Menu:" << endl;
		cout << "  1. Load Bids" << endl;
		cout << "  2. Display All Bids" << endl;
		cout << "  3. Find Bid" << endl;
		cout << "  4. Remove Bid" << endl;
		cout << "  5. Count Nodes" << endl;
		cout << "  9. Exit" << endl;
		cout << "Enter choice: ";
		cin >> choice;

		switch (choice)
		{

		case 1:
			bidTable = new HashTable();

			// Initialize a timer variable before loading bids
			ticks = clock();

			// Complete the method call to load the bids
			loadBids(csvPath, bidTable);

			// Calculate elapsed time and display result
			ticks = clock() - ticks; // current clock ticks minus starting clock ticks
			cout << "time: " << ticks << " clock ticks" << endl;
			cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;
			break;

		case 2:
			// Print a list of all bids
			bidTable->PrintAll();
			break;

		case 3:
			ticks = clock();

			// Search for the bid matching the given bidId
			bid = bidTable->Search(searchValue);

			ticks = clock() - ticks; // current clock ticks minus starting clock ticks

			if (!bid.bidId.empty())
			{
				displayBid(bid);
			}
			else
			{
				cout << "Bid Id " << searchValue << " not found." << endl;
			}

			cout << "time: " << ticks << " clock ticks" << endl;
			cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;
			break;

		case 4:
			// Remove a bid if one is found that matches the given bidId
			bidTable->Remove(searchValue);
			break;

		case 5:
			bidTable->CountNodes();
			break;
		}
	}

	cout << "Good bye." << endl;

	return 0;
}
