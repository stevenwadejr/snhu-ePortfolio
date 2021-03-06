# Enhancement One: Software Engineering/Design

The artifact for this milestone, Software Design/Engineering, is the final project from CS-260 and was originally completed in February 2020.  The artifact consists of examples of a binary search tree, a hash table, a linked list, and two vector sorting algorithms.  I chose to include this artifact in my portfolio because these data structures and algorithms are commonly used throughout computer science.  Translating these structures from C++ to PHP showcases my abilities in software development as it requires me to have an abstract understanding of the data structures rather than relying on concrete implementations.  The enhancement also showcases my skills at being able to adapt concepts between languages utilizing the strengths and addressing the weaknesses of the destination language.

One way the artifact was improved was by combining the execution of each demo through a parent console command.  Another way the artifact was improved was the reduction of time and cycles needed to loop through various data structures.  The latter was accomplished because the original C++ implementation used null pointers which took up slots within vectors meaning these still needed to be checked.  Using PHP arrays and absence of null pointers in the PHP language, the algorithms could be simplified to traverse only the nodes that existed thus reducing memory and compute cycles.  Further improvements were done through the simplification and reduction in logical branching.  Utilizing the dynamic nature of PHP, certain values, and methods, such as whether to traverse the left or right subtrees of a binary search tree, could be declared using a ternary operator and then the dynamic method called on the data structure class, thus reducing the number of conditional statements in the implementation.  A smaller enhancement was adding colors to the console output to help important information stand out to the user more easily.

It is my belief that in this enhanced artifact, that I satisfied course outcomes CS-499-03 and CS-499-04 in Table 1 (SNHU, n.d.).  As for the remaining course outcomes, I plan to address CS-499-01 with Category Three: Databases, CS-499-05 with Category Two: Algorithms and Data Structures, and CS-499-02 with the final narrative.

The process of enhancing and modifying this artifact was more intensive and difficult than I originally imagined.  I believed that with my thirteen years of writing PHP professionally that the conversion would be simple.  I overestimated my abilities as I don???t often write console applications in PHP and I have never used these data structures or algorithms within PHP itself.  In my efforts to minimize code, I combined the inOrder functions within the binary search tree into a single function but started the function by setting the node to the root, which was null, so it kept trying to traverse each side and initiate a new node.  This led to a memory exhaustion error because of an infinite loop.  Other than that initial setback, most of the challenges faced were around the conversion of C++ code that relied on the existence of null pointers to PHP and whether to omit a value or check against the value null itself.  Overall, the process was a good learning experience and there are further enhancements that I discovered that I???d like to make to the final submission if time allows later in the term.


**Table 1**

*Course Outcomes*


|||
|---|---|
| CS-499-01 | Employ strategies for building collaborative environments that enable diverse audiences to support organizational decision making in the field of computer science |
| CS-499-02 | Design, develop, and deliver professional-quality oral, written, and visual communications that are coherent, technically sound, and appropriately adapted to specific audiences and contexts |
| CS-499-03 | Design and evaluate computing solutions that solve a given problem using algorithmic principles and computer science practices and standards appropriate to its solution, while managing the trade-offs involved in design choices |
| CS-499-04 | Demonstrate an ability to use well-founded and innovative techniques, skills, and tools in computing practices for the purpose of implementing computer solutions that deliver value and accomplish industry-specific goals |
| CS-499-05 | Develop a security mindset that anticipates adversarial exploits in software architecture and designs to expose potential vulnerabilities, mitigate design flaws, and ensure privacy and enhanced security of data and resources |


*Note*. From ???CS 499 Final Project Guidelines and Rubric??? by Southern New Hampshire University (SNHU) (n.d.), (https://learn.snhu.edu/content/enforced/751280-CS-499-T5476-OL-TRAD-UG.21EW5/Course%20Documents/CS%20499%20Final%20Project%20Guidelines%20and%20Rubric.pdf)

**Link to the code:** [Original](https://github.com/stevenwadejr/snhu-ePortfolio/tree/gh-pages/project-files/software-engineering-design/original), [Enhanced](https://github.com/stevenwadejr/snhu-ePortfolio/tree/gh-pages/project-files/software-engineering-design/enhanced)


## References

<div class="reference">
Southern New Hampshire University (SNHU). (n.d.). *CS 499 final project guidelines and rubric*. Retrieved from https://learn.snhu.edu/content/enforced/751280-CS-499-T5476-OL-TRAD-UG.21EW5/Course%20Documents/CS%20499%20Final%20Project%20Guidelines%20and%20Rubric.pdf
</div>
