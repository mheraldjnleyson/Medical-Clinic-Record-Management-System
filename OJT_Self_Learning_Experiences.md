# Weekly Self-Learning Experiences
**Internship Journey: Development of the School Clinic Management System**
**Duration:** 13 Weeks

---

### Week 1: Requirements Gathering and UI/UX Design Principles

During the first week of my internship, I had to self-learn the principles of system requirements analysis and user interface and user experience design. I began by researching techniques on how to conduct structured interviews with medical professionals, learning how to translate clinical workflows into precise technical requirements. I watched video tutorials and read articles on the differences between functional requirements, which describe what the system should do, and non-functional requirements, which describe how the system should perform. This distinction helped me craft a clearer and more organized project scope before writing a single line of code.

In terms of design, I taught myself how to use Figma, a digital design tool I had minimal prior experience with. I followed step-by-step tutorials on how to construct reusable UI components, establish typographic hierarchies, use color palettes, and maintain consistent spacing and margins across all screens. I studied accessibility standards, particularly color contrast ratios and font size minimums, to ensure the interface would be usable for all clinic personnel regardless of age or visual ability.

I also learned about wireframing methodologies. I discovered the importance of starting with low-fidelity sketches to map out navigation flows before committing to high-fidelity visual designs. This iterative approach saved time because layout problems were identified and resolved early. I researched user-centered design principles, specifically how to reduce cognitive load by grouping related fields together and providing clear visual hierarchy on forms.

By the end of the week, I had developed a solid understanding of how to gather requirements professionally and translate them into clean design prototypes. This week taught me that great software always begins not with code, but with careful listening, research, and thoughtful visual planning.

---

### Week 2: Database Design, PHP CRUD Operations, and Responsive CSS

This week, I focused on three areas: database design, server-side scripting with PHP, and responsive CSS layout techniques. Although I had basic exposure to SQL, I had to self-study database normalization to ensure that the clinic system's database schema was efficient, non-redundant, and logically structured. I learned how to set up primary keys and foreign keys to enforce referential integrity between related tables, such as linking patient records to their corresponding consultation logs.

On the programming side, I researched how to build a dynamic CRUD system using PHP and MySQL. I studied how HTTP POST and GET request methods work and how data flows from HTML form fields through PHP scripts into MySQL database tables. I learned how to write reusable PHP functions to handle database connections and how to separate business logic from presentation using an MVC-inspired structure, even at a basic level.

I also studied the implementation of SQL database backup procedures using command-line tools. I learned how to generate a full database dump and how to write a Windows batch script that automates this backup process on a scheduled basis. This was important for ensuring that all clinic records could be restored in case of hardware failure or accidental data loss.

Lastly, I dived into CSS Flexbox, CSS Grid, and Media Queries to understand how to build a fully responsive website that automatically adjusts its layout across different screen sizes. I practiced creating fluid grid columns, collapsible navigation menus, and resizable form elements. I tested the layout on desktop, tablet, and mobile screen widths. This self-learning phase gave me a complete picture of how to build a functioning full-stack web application from the database layer up to the responsive user interface layer.

---

### Week 3: Web Application Security and JavaScript Automation

My self-learning this week centered heavily on web application security vulnerabilities and client-side JavaScript automation. I started by researching the most common web application threats listed in the OWASP Top Ten, paying particular attention to SQL injection, Cross-Site Scripting, and Cross-Site Request Forgery. I learned how each of these attacks works technically, why they are dangerous in a medical system context, and what the recommended countermeasures are.

To prevent SQL injection, I studied how to use PDO, which stands for PHP Data Objects, with prepared statements and parameterized queries. I practiced converting older-style MySQL queries into secure PDO equivalents and learned why this approach eliminates the risk of user-submitted input being interpreted as SQL commands. I also studied how password hashing algorithms like bcrypt work, understanding the concept of salting and multiple rounds of hashing, and why older algorithms like MD5 are no longer considered safe for storing sensitive credentials.

I learned how CSRF tokens work by generating a unique hidden token per form submission and validating it server-side, preventing malicious external websites from forging requests on behalf of authenticated users. Additionally, I researched Role-Based Access Control, learning how to assign permissions to specific user roles such as doctors, nurses, and administrators, and how to enforce these restrictions on every server-side request.

For the automation features, I self-taught intermediate-level JavaScript, specifically how to use Event Listeners and how to manipulate the Document Object Model in real time. I learned how to compute mathematical formulas like BMI using input field values and instantly update result fields without reloading the page. This combination of security hardening and front-end automation greatly improved both the safety and usability of the clinic system, and this week's self-learning gave me a much deeper appreciation of how security must be designed into every layer of a web application.

---

### Week 4: REST APIs, AI Research, and Apache Virtual Host Configuration

This week was dedicated to exploring how APIs work, researching AI integration possibilities, and learning how to configure a local Apache web server for custom domain hosting. I began by studying the fundamentals of RESTful API architecture, which is a standard design pattern for communication between web services. I learned about the different HTTP methods used in REST, specifically GET for retrieving data, POST for creating records, PUT for updating them, and DELETE for removing them. I also studied how JSON is used as the standard data exchange format between a client and an API server.

I explored the documentation of SMS API services to understand how to send automated text message notifications from a PHP web application. I studied how API keys, authentication headers, and cURL request structures work in PHP. This research was aimed at evaluating whether the clinic system could send appointment reminders or health advisories to students automatically in future updates.

I also researched lightweight artificial intelligence solutions. I studied how simple machine learning classification models work and explored whether any pre-trained medical symptom checker models could be integrated as a module. I documented my findings in terms of complexity, resource requirements, and accuracy to present to my supervisor.

On the server configuration side, I taught myself how to set up Apache Virtual Hosts by editing the `httpd-vhosts.conf` file. I learned how Virtual Hosts allow a single server to host multiple domain names by routing requests to different directories based on the requested hostname. I also learned how to modify the Windows hosts file to resolve custom local domain names to the loopback address. Understanding how DNS resolution works at the local level was a valuable networking lesson that connected my understanding of web servers with how networks route traffic.

---

### Week 5: Inventory Systems, Database Transactions, and ACID Principles

During Week 5, my self-learning revolved around building inventory control systems and understanding advanced database transaction management. I began by researching how inventory management systems are designed, focusing specifically on the core concepts of stock-in and stock-out operations, reorder thresholds, batch number tracking, and expiry date monitoring. I studied real-world medical inventory guidelines to understand how hospital pharmacies track controlled medicines and how alert systems notify staff when stock is running low or when medicines are nearing their expiration dates.

To implement the inventory logic within the clinic system, I needed to learn how the medication stock could be automatically reduced whenever a doctor prescribed medicine during a consultation. This required understanding database transactions. I studied the ACID model in depth, which stands for Atomicity, Consistency, Isolation, and Durability. I learned that Atomicity ensures that either all steps in a database operation succeed together or none of them do, which is critical when linking a prescription record to a stock deduction. If the prescription record fails to save, the stock count should not be reduced.

I learned how to write PHP transaction blocks using PDO, wrapping multiple SQL statements between `beginTransaction()`, `commit()`, and `rollBack()` calls. This ensured that the inventory deductions were always consistent with the actual prescription records in the database, preventing phantom stock discrepancies that would have been very difficult to audit in a busy clinic environment.

I also researched database triggers as an alternative approach and learned their differences from PHP transaction blocks in terms of performance and maintainability. By the end of this week, I had a clear understanding of how to build inventory logic that is tightly integrated with consultation workflows, ensuring that the clinic's medicine stock is always accurately reflected in the system without any manual intervention from the staff.

---

### Week 6: Network Infrastructure, Beta Testing Strategies, and Public Form Security

This week, my learning shifted toward computer networking concepts and structured software testing methodologies. I began by studying how local area networks operate, covering the roles of routers, network switches, and access points. I learned about static and dynamic IP address assignment, specifically how DHCP leases addresses automatically while static IP configuration ensures that critical devices like servers are always reachable at the same address.

I taught myself how to access a router's administrative gateway to configure DHCP reservations, which effectively assign a permanent local IP address to a specific device based on its MAC address. I also studied how to configure firewall port rules to allow other computers on the network to reach the web server running on port 80, enabling multi-device access to the clinic application across campus.

For beta testing, I researched structured testing strategies including black-box testing, functional testing, and user acceptance testing. I learned how to design a simple feedback form that guides users to report issues they encounter in a standardized way, covering areas such as page errors, incorrect data displays, and slow loading times. I also studied how to track and prioritize bug reports based on their severity and impact on the system.

I also learned about network segmentation to enable a public-facing form for students and employees without exposing the administrative backend. I studied how to create a separate subnet or guest Wi-Fi network that routes traffic only to the public form page, using firewall rules to prevent access to the main administrative panel from untrusted devices. This taught me how network design and software security work together, and by the end of the week, I had a well-rounded understanding of how to deploy a web system safely across a campus network environment.

---

### Week 7: Dynamic PDF Generation and Data Migration Planning

This week, I focused on learning how to generate dynamic PDF documents from within a PHP web application and how to plan and execute a structured data migration process. I began by researching available PHP PDF generation libraries and studying the differences between FPDF, TCPDF, and Dompdf in terms of features, file size, and ease of use. I chose TCPDF after learning that it supports UTF-8 character encoding, custom fonts, and complex table layouts, which were all necessary for generating professional medical certificates and referral forms.

I spent time reading the TCPDF documentation and practicing how to define page sizes, set custom margins, embed fonts, draw table borders, and insert dynamic text pulled from the database. I learned how CSS print media stylesheets work using the `@media print` rule, which allowed me to style web pages specifically for printing without affecting the on-screen display. This knowledge helped me create a print-friendly view for medical certificates in addition to the downloadable PDF format.

For data migration, I researched best practices for importing legacy data from paper-based records into a relational database. I studied data cleansing techniques, learning how to identify and resolve inconsistencies such as missing values, duplicate records, and mismatched date formats before importing. I learned how to write PHP scripts that pre-process raw data arrays, apply validation rules, and insert cleaned records into the database in batches.

I also studied how to handle data mapping, which involves translating field names and value formats from the old paper-based system into the structure of the new digital database. This was an important conceptual skill because the paper records used inconsistent shorthand notations that needed to be standardized. By the end of the week, I was fully prepared to handle the technical and procedural challenges of data migration.

---

### Week 8: Secure File Uploads, MIME Type Validation, and Server Directory Protection

During Week 8, my self-learning was focused on the secure handling of file uploads within the web application. I began by researching the potential security risks associated with allowing users to upload files to a web server. I learned that improperly validated uploads can allow attackers to upload PHP scripts disguised as image files, which can then be executed on the server to gain unauthorized access or destroy data. This is one of the most critical vulnerabilities in web applications that handle file uploads.

To mitigate these risks, I studied several layers of file upload security. First, I learned how to validate uploaded files using PHP's `finfo` class to check the actual MIME type of the file based on its binary content, rather than just trusting the file extension provided by the user. Second, I learned how to enforce maximum file size limits both on the client side using HTML attributes and on the server side using PHP configuration. Third, I studied how to programmatically rename uploaded files to randomized hash strings to prevent filename collisions and directory traversal attacks.

I also researched how to configure the Apache web server to prevent direct URL access to uploaded files. I learned how to write custom `.htaccess` rules that disable PHP script execution inside the uploads directory and deny direct browser access to all files within it. This ensures that even if a malicious file were uploaded, it could not be executed through a web request.

Additionally, I learned how to use PHP to serve files through a secure download script that first checks whether the logged-in user has the appropriate permissions before streaming the file to the browser. By the end of this week, I had built a comprehensive understanding of how to handle user-uploaded medical documents safely and responsibly within a sensitive clinical data environment.

---

### Week 9: SQL Query Optimization, Database Indexing, and File Permission Security

This week, I studied database performance tuning and server-side file permission management. As the volume of patient data in the clinic system database grew significantly due to ongoing data entry, I began to notice slower response times on the search and report pages. This prompted me to research how database query performance can be improved without changing the application's core logic.

I learned about database indexing in depth, studying how a database index functions similarly to an index at the back of a textbook, allowing the database engine to locate specific rows without scanning the entire table. I researched the different types of indexes, including single-column indexes, composite indexes that span multiple columns, and unique indexes that also enforce data constraints. I practiced using the `EXPLAIN` statement in MySQL to analyze query execution plans and identify which queries were performing full table scans instead of using indexes.

After analyzing the most frequently queried columns in the clinic system, such as patient names, ID numbers, and consultation dates, I added appropriate indexes to those columns. I also learned how to avoid common indexing mistakes such as over-indexing, which can slow down INSERT and UPDATE operations, and under-indexing, which leads to slow SELECT queries.

On the server security side, I researched file permission settings on Apache servers. I learned how read, write, and execute permissions work for the owner, group, and others on a web server context. I studied how to use `.htaccess` directives to disable directory listing, preventing users from browsing the contents of unprotected folders. I also learned how to restrict access to sensitive configuration files by adding `Deny from all` directives. This week's self-learning gave me a practical understanding of how performance and security are equally important in maintaining a reliable and trustworthy web system.

---

### Week 10: Structured Cabling, RJ45 Crimping, and Network Diagnostic Tools

During Week 10, my self-learning shifted from software development to physical network infrastructure. While assisting the school's IT department in resolving connectivity issues in the faculty offices, I had to quickly learn the fundamentals of structured cabling and local area network maintenance. I began by studying the different categories of twisted-pair Ethernet cables, specifically the differences between Cat5e and Cat6 in terms of bandwidth capacity, maximum transmission speed, and electromagnetic shielding. I learned that Cat6 cables are recommended for high-speed gigabit networks and are more resistant to crosstalk interference.

I studied the two standard wiring configurations for RJ45 connectors, specifically the T568A and T568B standards defined by the TIA/EIA wiring standards. I learned the correct wire color arrangement for each standard and when to use a straight-through cable versus a crossover cable depending on the devices being connected. I watched practical tutorial videos on how to properly strip the outer jacket of a cable, untwist and arrange the individual wire pairs in the correct order, trim them evenly, and firmly crimp the RJ45 connector using a crimping tool.

I also learned how to use a cable tester to verify that all eight wire pairs are correctly connected through the connector and that there are no open circuits, short circuits, or crossed pairs. This diagnostic tool was essential for confirming the quality of the cables we crimped before connecting them to the network switch.

Additionally, I studied basic command-line network diagnostic tools including `ping` to test device reachability, `ipconfig` to view and release IP configuration, `tracert` to trace network routing paths, and `nslookup` to query DNS records. This hands-on networking experience significantly broadened my technical skill set beyond software development.

---

### Week 11: Debugging Methodologies, Session Security, and Browser Compatibility

During the eleventh week, I focused on learning structured debugging methodologies and session management security to prepare the system for final deployment. I began by researching the different levels of PHP error reporting and how to configure the `php.ini` settings to log errors to a hidden file rather than displaying them directly to website visitors. I learned that exposing raw PHP error messages on a live server is a significant security risk because it can reveal database structure, file paths, and internal logic to attackers.

I studied how to use browser developer tools effectively for front-end debugging. I practiced using the Console panel to catch JavaScript runtime errors, the Network panel to inspect AJAX request payloads and server responses, and the Elements panel to examine how CSS rules are being applied or overridden. This toolset proved extremely useful for tracking down interface bugs that were not visible in the PHP error logs.

I also researched session management security in depth. I learned about session fixation attacks, where an attacker tricks a user into using a pre-set session ID, and session hijacking, where a session token is stolen from a network packet. To mitigate these risks, I studied how to regenerate session IDs upon successful login using `session_regenerate_id(true)`, and how to configure PHP session cookies with the `httponly`, `secure`, and `samesite` flags to reduce the attack surface.

Lastly, I researched browser compatibility and learned why certain CSS properties and JavaScript APIs behave differently across Google Chrome, Mozilla Firefox, and Microsoft Edge. I studied vendor prefixes and feature detection techniques. By understanding these compatibility differences, I was able to ensure that the clinic system's interface rendered correctly and consistently for all users regardless of their browser choice, which was an important quality assurance milestone.

---

### Week 12: Data Validation, Regular Expressions, and Database Load Testing

During Week 12, I focused on learning data validation techniques using regular expressions and database performance testing under concurrent load. As the data migration phase neared completion, I recognized the need to ensure that all the manually entered records were accurate and consistently formatted. This led me to research regular expressions, which are powerful text pattern matching tools used in PHP to validate and sanitize string inputs.

I studied how to construct regular expression patterns for different types of data. I learned how to write patterns that validate Philippine mobile phone numbers, verify that email addresses follow the correct format, and ensure that date values follow a consistent structure. I practiced writing PHP scripts that used these regex patterns to scan entire database tables and flag any records that contained incorrectly formatted values. This automated scanning process was far more efficient than manually reviewing thousands of records one by one.

I also learned about duplicate record detection, specifically how to write SQL queries using GROUP BY and HAVING clauses to identify patient profiles that had been entered more than once with slightly different spellings. I developed a consolidation script that flagged these duplicates for manual review and merging.

On the performance side, I researched database load testing methodologies. I studied how to simulate multiple concurrent database connections by writing PHP loops that spawn parallel queries and measure response times under simulated load conditions. I learned about connection pooling and the importance of limiting the number of open database connections to prevent server resource exhaustion.

I also studied how to analyze slow query logs in MySQL to identify which queries were taking the longest to execute during periods of high load. This knowledge helped me fine-tune remaining queries and ensure the clinic system remained fast and responsive even when multiple administrative staff were accessing it at the same time.

---

### Week 13: Web Hosting Deployment, SSL Configuration, and Technical Documentation Writing

In the final week of my OJT, I focused on three major areas: deploying the web application to a live server environment, configuring SSL for secure HTTPS connections, and learning how to write professional technical documentation and user manuals. I began by researching how shared web hosting and virtual private server hosting environments work. I studied how to use cPanel to manage hosting accounts, create MySQL databases, set up FTP users, and configure domain name settings.

I learned how to export the full local database using mysqldump and import it into the remote hosting environment's MySQL server. I also learned how to update the system's PHP configuration files with the new database credentials and server paths to ensure that all connections were correctly re-established in the production environment.

For SSL configuration, I researched how the Secure Sockets Layer protocol works to encrypt data transmitted between the user's browser and the web server. I learned about symmetric and asymmetric encryption and how SSL certificate authorities validate domain ownership. I studied how to install a free SSL certificate using Let's Encrypt and how to configure Apache to force HTTPS redirects, ensuring that all traffic to the clinic system is encrypted.

I also spent significant time learning how to write technical documentation. I studied the principles of clear technical writing, including how to organize content with numbered steps, use simple and precise language, include screenshots to illustrate steps, and organize the manual into role-specific sections for administrators, doctors, and nurses. I learned that effective documentation is just as important as the software itself, because it empowers end users to operate the system confidently without requiring constant developer support. This final week marked the complete end-to-end lifecycle of a real-world software project.
