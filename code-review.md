# Code Review

<iframe width="560" height="315" src="https://www.youtube.com/embed/r5IRmmm8fT8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

## Enhancements List

### Category One: Software Design and Engineering
* Convert data structures (binary search tree, hash table, linked list) and sorting algorithms (quick sort, selection sort) from the original implementation in C++ to PHP
* Convert each original C++ demo’s “main” function with command line menus and prompts into Symfony based console commands
* Create a console application compromised of each demo’s commands (binary search tree, hash table, linked list, and sorting algorithms) that creates a more user friendly and consistent command line interface, shares code between commands, handles errors and reporting, and makes it simple to identify and run artifact commands
* Reduce the number of nested conditional statements (if/else)

### Category Two: Algorithms and Data Structure
* Convert from a command line interface to a graphical user interface application
* Improve efficiency by reading credential and role files into memory at runtime
* Store credentials and roles in appropriate data structures to allow for quickly searching for the desired information. This contrasts with the artifact’s existing functionality that reads credentials from a file line by line and reads a role file on demand.
* Add secure coding best practices to the application 

### Category Three: Databases
* Export the survey data from a JMP program file to a CSV and then create a new MongoDB database from that CSV data
* Create a NodeJS backend API to query MongoDB based on reports and data extracted with JMP during the DAT-220 class
* Create predefined useful report queries that were not part of the original report and project from DAT-220
* Create an HTML and JavaScript frontend dashboard to display report data
* Reports will be categorized together based on type of data or usefulness
* Report categories will be separated into individual “pages” within a single page JavaScript application
* Report data will be displayed using 3rd-party libraries such as D3.js or Chart.js, or similar libraries