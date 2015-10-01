# Ink-Stock-Manager
Manage stock values, complete Stock Checks, produce reports and review audits

Transitioning to open source from a private and closed project.

The project was neglected, currently requires a LOT of bug fixes.

# Backstory
Where I work, Ink and Toner stock levels were managed in a spreadsheet. 
Apart from being wildly inaccurate at times, there were issues with not ordering 
stock, not knowing what needed ordering, when toner had been taken...the list 
continues. Most important of all, the spreadsheet was a pain to maintain. 

The core idea for Ink Stock Manager was to have a database that was fast and convenient to work with. 
The database would also be able to produce a series of 'reports' to reduce admin work at the end of 
each year (how much cash was spent on x printer etc etc etc)

# Features
<ul>
<li>Stock level monitoring</li>
<li>Auditing</li>
<li>Reporting</li>
<li>API</li>
<li>Purchase order assistant</li>
</ul>

# ToDo

1. Bug Squashing!!!
2. Continue migration to Ajax/API
3. Get feature sprawl under control
4. Documentation
5. Automated/assisted installation

# Installation

Installation is currently not automated, please follow these instructions: 

1. Unpack into web directory
2. Create MySQL database
3. Import the inkstock.sql file into MySQL database
4. Complete Variables in config/config.php
5. Visit site index and create initial user
6. Start using Ink Stock Manager!