# Enhancement Two: Algorithms and Data Structure

The artifact for this milestone, Algorithms and Data Structure, is the final project from IT-145 and was originally completed in April 2019.  This artifact consists of a Java application with a command line interface (CLI) that allows a user to login to the application, and once authenticated, they are greeted with a welcome message based on their defined user role.  I chose to include this artifact in my portfolio because user authentication and role base permissions are common applications within software engineering.  More so, a reason I wanted to include the artifact was for the enhancements I wanted to perform – mainly, translating the application from a CLI application to a graphical user interface (GUI) application.  The enhancement showcases my skills at being able to adapt a program and create a separate client interface for a similar backend interface while learning and developing new skills along the way.

The first way this artifact was improved was the creation of a GUI for the user to interact with rather than having to use a terminal and type in commands.  Through the conversion of the application from a command-based interface to a graphical interface, the overall security of the application was improved.  This security improvement was accomplished because with an interface that requires commands be typed in, users could maliciously or accidentally cause a buffer overflow and expose sensitive pieces of code if the application is not properly guarded.  The use of pre-defined graphical components handles what type of data can be entered into the fields, and actions are done with a mouse rather than text commands.  This limits the risk of the application.

A second enhancement to the artifact was the use of data structures and simple algorithms to find users and role information.  The original CLI implementation loaded the user credentials file on-demand when a login attempt was made, and a role information file was loaded only when it needed to be accessed.  With this artifact, I enhanced the behavior by loading all users from the credentials file and all role information files when the application is booted.  User records are created as user models and stored in a hash map using the user’s username as a unique key, and roles are similarly stored in a hash map with the role name as the unique index key.  This enhancement made it easier and quicker to find a user record or role information using built-in Java data structures and algorithms.  Overall, the application has been improved from security, performance, and user experience standpoints.

I believe that this enhanced artifact satisfies course outcomes CS-499-03, CS-499-04, and CS-499-05 in Table 1 (SNHU, n.d.) by using appropriate design patterns where needed, reducing the security vulnerability by restricting user interactions, and by implementing a new client interface for existing code while simultaneously improving and expanding the original code base.  This artifact overlaps addressing outcomes CS-499-03 and CS-499-04 with Category One.  Course outcomes CS-499-01 will be addressed with Category Three: Databases, while the final narrative will address CS-499-02.

The process of enhancing and modifying this artifact went about as well as I expected.  The rubric for the final project states that only one enhancement must be performed, but for this artifact I chose to do two enhancements: “improve efficiency” and “expand complexity” (SNHU, n.d.).  I had a plan to improve the efficiency of the artifact by preloading the text file resources and storing their contents in memory with hash maps, but my plan for expanding the complexity was to build an entirely new interface – a graphical one.  Prior to this project I had not written a GUI in Java, so I had to search the web for every question I had or issue I got stuck on.  This involved me rewriting portions of the application multiple times as I learned how to create different aspects of a GUI within Java.  I understand that the way I have built this GUI application may not be standard practice for experienced Java developers, but it works well, and the code is structured in a clean and organized manner; therefore, I am satisfied with the way the artifact and its enhancements turned out.  I accomplished the goals that I outlined in Module One that I wanted to accomplish.

**Table 1**

*Course Outcomes*


|||
|---|---|
| CS-499-01 | Employ strategies for building collaborative environments that enable diverse audiences to support organizational decision making in the field of computer science |
| CS-499-02 | Design, develop, and deliver professional-quality oral, written, and visual communications that are coherent, technically sound, and appropriately adapted to specific audiences and contexts |
| CS-499-03 | Design and evaluate computing solutions that solve a given problem using algorithmic principles and computer science practices and standards appropriate to its solution, while managing the trade-offs involved in design choices |
| CS-499-04 | Demonstrate an ability to use well-founded and innovative techniques, skills, and tools in computing practices for the purpose of implementing computer solutions that deliver value and accomplish industry-specific goals |
| CS-499-05 | Develop a security mindset that anticipates adversarial exploits in software architecture and designs to expose potential vulnerabilities, mitigate design flaws, and ensure privacy and enhanced security of data and resources |


*Note*. From “CS 499 Final Project Guidelines and Rubric” by Southern New Hampshire University (SNHU) (n.d.), (https://learn.snhu.edu/content/enforced/751280-CS-499-T5476-OL-TRAD-UG.21EW5/Course%20Documents/CS%20499%20Final%20Project%20Guidelines%20and%20Rubric.pdf)

**Link to the code:** [Original](https://github.com/stevenwadejr/snhu-ePortfolio/tree/gh-pages/project-files/algorithms-data-structures/original), [Enhanced](https://github.com/stevenwadejr/snhu-ePortfolio/tree/gh-pages/project-files/algorithms-data-structures/enhanced)

## References

<div class="reference">
Southern New Hampshire University (SNHU). (n.d.). *CS 499 final project guidelines and rubric*. Retrieved from https://learn.snhu.edu/content/enforced/751280-CS-499-T5476-OL-TRAD-UG.21EW5/Course%20Documents/CS%20499%20Final%20Project%20Guidelines%20and%20Rubric.pdf
</div>