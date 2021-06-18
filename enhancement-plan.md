# Enhancement Plan

## Category One

The artifact that I’ve chosen for this category is the final project from CS-260. In the original project, I was tasked with building a binary search tree, a hash table, a linked list, and performing quick and selection sorts using a vector. The code was written in C++ but for this artifact, I’d like to convert it to PHP. This conversion relates to the software engineering/design category as sometimes as engineers we will find examples or solutions presented in another piece of software or language that we must be able to translate and adapt to a project in another language. Binary search trees, hash tables, and linked lists aren’t commonly found in PHP projects, so I believe it’ll be intriguing and challenging to implement them utilizing the structures and types built into PHP itself. To perform the conversion, I will extract some each data structure into its own file and class, as well any structures from C++ such as Bid and Node into their own class files as well. The CS-260 project utilized a provided CSV parser so I’ll either utilize the built-in CSV parsing abilities of PHP or utilize a third-party library. To tie these data structures together, I’ll create a script PHP file that includes all the classes and will run the proper example based upon a CLI command provided (see pseudocode below for the example script runner). A successful conversion of this artifact will demonstrate my ability to understand the core functionality of a piece of software and execute it in multiple languages utilizing the best features and performance considerations for each language. This will satisfy the outcome "design and evaluate computing solutions that solve a given problem using algorithmic principles and computer science practices and standards appropriate to its solution, while managing the trade-offs involved in design choices."
This program will act as a multi-example "main" function for the various data structures.

**Enhancement One Pseudocode**

```
READ arguments
IF CSV file path is present:
	SET csvPath to argument value
ELSE:
	SET csvPath to default file

DISPLAY menu to select which program to run

IF answer is 1:
	RUN the binary search tree program
ELSE IF answer is 2:
	RUN the hash table program
ELSE IF answer is 3:
	RUN the linked list example
ELSE IF answer is 4:
	RUN the vector sorting program
ELSE IF answer is q:
	QUIT the program
```

## Category Two

The artifact that I’ve chosen to showcase the category for Algorithms and Data Structure is the final project from IT-145. In the original project was a command line program zoo authentication program. Credentials would be provided for a given role and information pertaining to that role would be displayed following a successful login. To improve this project, I’d like to address both improving the efficiency and expanding the complexity. The code is written in Java and as such, I’d like to upgrade the program to add a graphical user interface (GUI). In addition, I’m going to utilize built-in Java classes such as a HashMap to preload the users, user information, and credentials to handle the authentication immediately at runtime instead of loading files on-demand as shown below in the flowchart. The skills that will be demonstrated in this artifact will be utilizing the data structures and algorithms learned in CS-260 and translating them from C++ to Java and adapting them to this application’s use case. The course outcome that will be satisfied by this artifact will be "develop a security mindset that anticipates adversarial exploits in software architecture and designs to expose potential vulnerabilities, mitigate design flaws, and ensure privacy and enhanced security of data and resources" as the application will need to be secure to prevent users from accessing information about another type of role.

**Enhancement Two Flow Chart**

![Enhancement Two Flow Chart](/images/it-145-app.png)

## Category Three

The artifact that I have chosen for the Databases category is the final project from CS-340. The original project is a Python application using the Dash framework that queries a MongoDB database and displays results on a dashboard. To improve this artifact, I plan to perform the suggested modification "build a full stack with a different programming language." The original project is written in Python, but I plan to rebuild this project in JavaScript using NodeJS as the backend server. JavaScript is the most popular programming language (Tung, 2020) so using it to write the backend server and the frontend dashboard showcases the outcome of building collaborative environments that enable diverse audiences. The outcome is demonstrated through this conversion because of JavaScript’s popularity around the world which would open the application development team to more candidates which aids in organizational decision making. The flowchart below shows how the NodeJS server will communicate to the MongoDB database and then pass the data to the JavaScript frontend to display the results.

**Enhancement Three Flow Chart**

![Enhancement Three Flow Chart](/images/cs-340-app.png)

## ePortfolio Overall

Upon completion of the ePortfolio, including the code review and all improved artifacts, I will have demonstrated knowledge of industry standards, secure coding, appropriate use of data structures and algorithms, and skills related to self-reflection and objective review and assessment of my code. I believe that all the course outcomes will be satisfied. Outcomes CS-499-01, CS-499-03, CS-499-04, and CS-499-05 in Table 1 (SNHU, n.d.) will be satisfied by the artifacts themselves, while CS-499-02 will be satisfied by the code review and the self-reflection. The self-reflection will mainly satisfy the CS-499-02 – professional-quality written communications that are coherent, technically sound, and appropriately adapted to specific audiences and contexts – outcome that will introduce myself, summarize what I’ve learned at Southern New Hampshire University, and how those skills can apply to the professional world. One weakness that I can identify as potentially problematic will be the artifact narratives. I need to focus on these as much as the code itself and use the narratives to justify my selection of artifacts and properly communicate lessons I learned.

**Table 1**

_Course Outcomes_

|           |                                                                                                                                                                                                                                    |
| --------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| CS-499-01 | Employ strategies for building collaborative environments that enable diverse audiences to support organizational decision making in the field of computer science                                                                 |
| CS-499-02 | Design, develop, and deliver professional-quality oral, written, and visual communications that are coherent, technically sound, and appropriately adapted to specific audiences and contexts                                      |
| CS-499-03 | Design and evaluate computing solutions that solve a given problem using algorithmic principles and computer science practices and standards appropriate to its solution, while managing the trade-offs involved in design choices |
| CS-499-04 | Demonstrate an ability to use well-founded and innovative techniques, skills, and tools in computing practices for the purpose of implementing computer solutions that deliver value and accomplish industry-specific goals        |
| CS-499-05 | Develop a security mindset that anticipates adversarial exploits in software architecture and designs to expose potential vulnerabilities, mitigate design flaws, and ensure privacy and enhanced security of data and resources   |

_Note_. From "CS 499 Final Project Guidelines and Rubric” by Southern New Hampshire University (SNHU) (n.d.), (https://learn.snhu.edu/content/enforced/751280-CS-499-T5476-OL-TRAD-UG.21EW5/Course%20Documents/CS%20499%20Final%20Project%20Guidelines%20and%20Rubric.pdf)

## References

<div class="reference">
Southern New Hampshire University (SNHU). (n.d.). *CS 499 final project guidelines and rubric*. Retrieved from https://learn.snhu.edu/content/enforced/751280-CS-499-T5476-OL-TRAD-UG.21EW5/Course%20Documents/CS%20499%20Final%20Project%20Guidelines%20and%20Rubric.pdf
</div>
<div class="reference">
Tung, L. (2020, October 21). *Programming language popularity: JavaScript leads – 5 million new developers since 2017*. ZDNet. https://www.zdnet.com/article/programming-language-popularity-javascript-leads-5-million-new-developers-since-2017/.
</div>
