# rpmetaller-editor
A web-based tool to store, manage and publish information about concerts.

I used this project to learn PHP and MySQL, so the code is safe but not as clean as it could be. The project will be rewritten later. Bug fixes will continue to be implemented.
## Features
* Save and edit data about concerts and festivals (bands, date, venue).
* Edit the names of bands, cities, venues.
* Export concerts and festivals in human readable form.
* Mark bands, whose concerts should not be exported.
## Requirements
The software does not have any special needs. A reasonably current version of PHP, the web server and MySQL or MariaDB should do the job. It is best to try it out.
### Definitely working configuration
* PHP 7.4
* Apache 2.5
* MariaDB 10.4 or MySQL 8.0

or newer.
## Installation hints
To install the software the following steps are necessary:
* Install and configure PHP, the Webserver and MariaDB or MySQL.
* Make the content of the folder “php” accessible for the web server.
* Import the database from the file “databases_rpm.sql” into your database management software.
* Adjust the file “connect.php” from the php folder.
## Contact
If you have any question, just drop a message at thorres[at]brothersofgrey[dot]net.
