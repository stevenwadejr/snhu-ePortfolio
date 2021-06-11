# Enhancement Three: Databases

The artifact for this milestone, Databases, is the final project from DAT-220 and was originally completed in August 2020.  For that class’ final project, a database of customer survey data was analyzed using a data mining program to build reports including graphs and charts.  The final report represented information that was formatted for a regular user while extracting useful information from the database required skilled knowledge of the data mining software used.  I chose to include this artifact in my portfolio because this scenario represented a plausible project within the real world.  While the original database required paid software and expert knowledge to use, the enhancement performed in this milestone created a user-friendly HTML and JavaScript dashboard that shows similar graphs and charts as the original analysis documents.  The enhancement showcases my skills at being able to translate and extrapolate useful data from a database into a user-friendly and presentable interface that customers could read and understand themselves.

The first way this artifact was improved was the creation of a HTML and JavaScript dashboard showcasing report data previously only accessible by developers with knowledge of and access to paid data mining software.  To accomplish this, I exported the original database from the paid software format to an open JSON format and then imported the data into a MongoDB database (MongoDB, Inc., n.d.).  The reports from the original analysis document were recreated as MongoDB queries and powered by a Node.js application (OpenJS Foundation, n.d.).
Another way the artifact was improved was the development of a frontend graphical user interface (GUI) to display the pre-defined report data.  The reports were organized into a logical separation as pages within the application.  Each frontend page requests that page’s report data through calls to a backend application programming interface (API).  Further enhancements to this artifact were made through interactive charts and graphs that display their respective report data.

I believe that this enhanced artifact satisfies course outcomes CS-499-01, CS-499-03, and CS-499-04 in Table 1 (SNHU, n.d.) by making the customer survey data more accessible to general users and by using industry leading frameworks and platforms to build a dashboard to organize and display mined data.  This artifact overlaps addressing outcomes CS-499-03 and CS-499-04 with categories One and Two.  Course outcome CS-499-02 will be addressed in the final narrative.

The process of enhancing and modifying this artifact did not go as smoothly as the previous two enhancement categories.  For starters, prior to this enhanced artifact, I had never built a Node.js application (OpenJS Foundation, n.d.), only had rudimentary experience with MongoDB (MongoDB, Inc., n.d.), and had never used the graphing and chart library Chart.js (Chart.js, n.d.).  The rubric for the final project suggests “create a MongoDB interface with HTML/JavaScript” as an enhancement to Category Three (SNHU, n.d.), but my inexperience in these some of these areas meant that I had to learn each piece of technology as I went along.  I knew the user-experience that I wanted for the final enhancement, but I did not want to compromise on quality for the sake of time or inexperience.  Despite this project taking longer than I expected to complete and my lack of experience in some of the technology used, I am extremely pleased with the outcome.  The enhanced artifact is exactly what I pictured and planned in the initial refinement plan submitted in Module One.

**Table 1**
  *Course Outcomes*

<div class="course-outcomes-table">

|||
|---|---|
| CS-499-01 | Employ strategies for building collaborative environments that enable diverse audiences to support organizational decision making in the field of computer science |
| CS-499-02 | Design, develop, and deliver professional-quality oral, written, and visual communications that are coherent, technically sound, and appropriately adapted to specific audiences and contexts |
| CS-499-03 | Design and evaluate computing solutions that solve a given problem using algorithmic principles and computer science practices and standards appropriate to its solution, while managing the trade-offs involved in design choices |
| CS-499-04 | Demonstrate an ability to use well-founded and innovative techniques, skills, and tools in computing practices for the purpose of implementing computer solutions that deliver value and accomplish industry-specific goals |
| CS-499-05 | Develop a security mindset that anticipates adversarial exploits in software architecture and designs to expose potential vulnerabilities, mitigate design flaws, and ensure privacy and enhanced security of data and resources |

</div>

*Note*. From “CS 499 Final Project Guidelines and Rubric” by Southern New Hampshire University (SNHU) (n.d.), (https://learn.snhu.edu/content/enforced/751280-CS-499-T5476-OL-TRAD-UG.21EW5/Course%20Documents/CS%20499%20Final%20Project%20Guidelines%20and%20Rubric.pdf)

**Link to the code:** [Original](https://github.com/stevenwadejr/snhu-ePortfolio/tree/gh-pages/project-files/databases/original), [Enhanced](https://github.com/stevenwadejr/snhu-ePortfolio/tree/gh-pages/project-files/databases/enhanced), [Life demo of the enhanced artifact](https://cs499.swade.dev/)

## References

<div class="reference">
Chart.js (n.d.). *Open source HTML5 charts for your website.* https://www.chartjs.org/
</div>
<div class="reference">
MongoDB, Inc. (n.d.). *The database for modern applications.* https://www.mongodb.com/
</div>
<div class="reference">
OpenJS Foundation (n.d.). *About Node.js.* https://nodejs.org/en/about/
</div>
<div class="reference">
Southern New Hampshire University (SNHU). (n.d.). *CS 499 final project guidelines and rubric.* Retrieved from https://learn.snhu.edu/content/enforced/751280-CS-499-T5476-OL-TRAD-UG.21EW5/Course%20Documents/CS%20499%20Final%20Project%20Guidelines%20and%20Rubric.pdf
</div>