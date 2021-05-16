//============================================================================
// Name        : BinarySearchTree.cpp
// Author      : Steven Wade
// Course      : CS-260-J3567 Data Structures and Algorithms 20EW3
// Date        : 2020-02-02
// Project     : 6-2 Programming Activity: Trees
// Version     : 1.0
// Copyright   : Copyright © 2020 SNHU COCE and Steven Wade
//============================================================================

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

struct Node {
	Bid bid;
	Node* left;
	Node* right;

	// Initialize with null pointers for the left and right nodes
	Node() {
		left = nullptr;
		right = nullptr;
	}

	// Initialize with a bid while also calling the parent constructor
	Node(Bid b): Node() {
		this->bid = b;
	}
};

//============================================================================
// Binary Search Tree class definition
//============================================================================

/**
 * Define a class containing data members and methods to
 * implement a binary search tree
 */
class BinarySearchTree {

private:
    Node* root;
    int size;

    void addNode(Node* node, Bid bid);
    void inOrder(Node* node);
    Node* removeNode(Node* node, string bidId);

public:
    BinarySearchTree();
    virtual ~BinarySearchTree();
    void InOrder();
    void Insert(Bid bid);
    void Remove(string bidId);
    Bid Search(string bidId);
    int Size();
};

/**
 * Default constructor
 */
BinarySearchTree::BinarySearchTree() {
    // Safety measure - initialize the root with a null pointer
	root =  nullptr;
	size = 0;
}

/**
 * Destructor
 */
BinarySearchTree::~BinarySearchTree() {
    // recurse from root deleting every node
}

/**
 * Traverse the tree in order
 */
void BinarySearchTree::InOrder() {
	this->inOrder(root);
}
/**
 * Insert a bid
 */
void BinarySearchTree::Insert(Bid bid) {
	// If the root isn't set, set it with a new node
	if (root == nullptr) {
		root = new Node(bid);
	} else {
		// Add a new node to the tree starting at the root - the `addNode` will recursively
		// scan the tree and insert the bid where it needs to go.
		this->addNode(root, bid);
	}

	++size;
}

/**
 * Remove a bid
 */
void BinarySearchTree::Remove(string bidId) {
	// Start at the root node and search for the bid to remove
	this->removeNode(root, bidId);
}

/**
 * Search for a bid
 */
Bid BinarySearchTree::Search(string bidId) {
	// Point the current node to the root to start the search
	Node* current = root;

	// Loop through until the current node is a null pointer
	while (current != nullptr) {
		// Check to see if current node matches
		if (current->bid.bidId.compare(bidId) == 0) {
			return current->bid;
		}

		// Traverse the left subtree if less than, else check the right subtree
		if (bidId.compare(current->bid.bidId) < 0) {
			current = current->left;
		} else {
			current = current->right;
		}
	}

	Bid bid;
    return bid;
}

int BinarySearchTree::Size() {
	return size;
}

/**
 * Add a bid to some node (recursive)
 *
 * @param node Current node in tree
 * @param bid Bid to be added
 */
void BinarySearchTree::addNode(Node* node, Bid bid) {

	// If the new node is larger then pass to left subtree
	if (bid.bidId.compare(node->bid.bidId) < 0) {
		// No left subtree exists, so let's create one
		if (node->left == nullptr) {
			// Set the node's left tree to a new node
			node->left = new Node(bid);
		} else {
			// A left subtree exists for this node, so we need
			// to recursively traverse it to insert it into
			// the correct position left or right within that tree.
			this->addNode(node->left, bid);
		}
	// Add to the right subtree
	} else {
		// No right subtree exists, so let's create one
		if (node->right == nullptr) {
			// Set the node's right tree to a new node
			node->right = new Node(bid);
		} else {
			// A right subtree exists for this node, so we
			// need to recursively traverse it to insert it into
			// the correct position left or right within that tree.
			this->addNode(node->right, bid);
		}
	}
}

void BinarySearchTree::inOrder(Node* node) {
	// Safety check to ensure we don't work on a null node
	if (node != nullptr) {
		// Recursively traverse the left subtree to display its contents
		inOrder(node->left);

		// A node is found so let's display the bid
		cout << node->bid.bidId << ": " << node->bid.title << " | " << node->bid.amount << " | "
				<< node->bid.fund << endl;

		// Recursively traverse the right subtree to display its contents
		inOrder(node->right);
	}
}

Node* BinarySearchTree::removeNode(Node* node, string bidId) {
	// Bail if the node doesn't exist
	if (node == nullptr) {
		return node;
	}

	// Check the left subtree first
	if (bidId.compare(node->bid.bidId) < 0) {
		// Set the node's left node to the value remainder of the tree
		// that's returned from removing the left's children
		node->left = removeNode(node->left, bidId);

	// Check the right subtree
	} else if (bidId.compare(node->bid.bidId) > 0) {
		// Set the node's right node to the value remainder of the tree
		// that's returned from removing the right's children
		node->right = removeNode(node->right, bidId);
	} else {
		// If this is a leaf node
		if (node->left == nullptr && node->right == nullptr) {
			delete node;
			node = nullptr;

			--size;

		// One child to the left
		} else if (node->left != nullptr && node->right == nullptr) {
			// Create a temp node to reference the current node
			Node* tempNode = node;

			// Overwrite the node with that of its right subtree
			node = node->right;

			// Delete the original node since we found the one we were looking for
			delete tempNode;

			--size;

		// One child to the right
		} else if (node->right != nullptr && node->left == nullptr) {
			// Create a temp node to reference the current node
			Node* tempNode = node;

			// Overwrite the node with that of its left subtree
			node = node->left;

			// Delete the original node since we found the one we were looking for
			delete tempNode;

			--size;

		// Two children
		} else {
			// Create a temp node referencing/storing the right subtree
			Node* tempNode = node->right;

			// Loop through the left subtree all the way down continuing left
			// to find the last instance of the left child
			while (tempNode->left != nullptr) {
				tempNode = tempNode->left;
			}

			// Override the current node's bid with that of the last child's
			node->bid = tempNode->bid;

			// Overwrite the right subtree
			node->right = removeNode(node->right, tempNode->bid.bidId);
		}
	}

	return node;
}

//============================================================================
// Static methods used for testing
//============================================================================

/**
 * Display the bid information to the console (std::out)
 *
 * @param bid struct containing the bid info
 */
void displayBid(Bid bid) {
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
void loadBids(string csvPath, BinarySearchTree* bst) {
    cout << "Loading CSV file " << csvPath << endl;

    // initialize the CSV Parser using the given path
    csv::Parser file = csv::Parser(csvPath);

    // read and display header row - optional
    vector<string> header = file.getHeader();
    for (auto const& c : header) {
        cout << c << " | ";
    }
    cout << "" << endl;

    try {
        // loop to read rows of a CSV file
        for (unsigned int i = 0; i < file.rowCount(); i++) {

            // Create a data structure and add to the collection of bids
            Bid bid;
            bid.bidId = file[i][1];
            bid.title = file[i][0];
            bid.fund = file[i][8];
            bid.amount = strToDouble(file[i][4], '$');

            //cout << "Item: " << bid.title << ", Fund: " << bid.fund << ", Amount: " << bid.amount << endl;

            // push this bid to the end
            bst->Insert(bid);
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

    // Define a timer variable
    clock_t ticks;

    // Define a binary search tree to hold all bids
    BinarySearchTree* bst;

    Bid bid;

    int choice = 0;
    while (choice != 9) {
        cout << "Menu:" << endl;
        cout << "  1. Load Bids" << endl;
        cout << "  2. Display All Bids" << endl;
        cout << "  3. Find Bid" << endl;
        cout << "  4. Remove Bid" << endl;
        cout << "  9. Exit" << endl;
        cout << "Enter choice: ";
        cin >> choice;

        switch (choice) {

        case 1:
            bst = new BinarySearchTree();

            // Initialize a timer variable before loading bids
            ticks = clock();

            // Complete the method call to load the bids
            loadBids(csvPath, bst);

            cout << bst->Size() << " bids read" << endl;

            // Calculate elapsed time and display result
            ticks = clock() - ticks; // current clock ticks minus starting clock ticks
            cout << "time: " << ticks << " clock ticks" << endl;
            cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;
            break;

        case 2:
            bst->InOrder();
            break;

        case 3:
            ticks = clock();

            bid = bst->Search(bidKey);

            ticks = clock() - ticks; // current clock ticks minus starting clock ticks

            if (!bid.bidId.empty()) {
                displayBid(bid);
            } else {
            	cout << "Bid Id " << bidKey << " not found." << endl;
            }

            cout << "time: " << ticks << " clock ticks" << endl;
            cout << "time: " << ticks * 1.0 / CLOCKS_PER_SEC << " seconds" << endl;

            break;

        case 4:
            bst->Remove(bidKey);
            break;
        }
    }

    cout << "Good bye." << endl;

	return 0;
}
