## Installation

Put all files in the public folder of your server. 
Import database file into your database. (perkamkopa.sql.gz)
Configure your database variables in the /config/database.php file.

## Comments

For safety CHMOD should be set to 644 for directories and subdirectories:
* /app/
* /bootstrap/
* /config/
* /views/

Some scenarios are not tested. For example:
* What happens if session is disrupted
* What happens if answers or questions are deleted from database
* Form resubmission for same question
* ect.