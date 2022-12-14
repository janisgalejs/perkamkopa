## Requirements

* PHP version >= 7.4 (recommended >= 8.0)
* PHP PDO extension
* MySQL database >= 5.7

## Installation

* Put all files in the public folder on your server.
* Import database file (perkamkopa.sql.gz) into your database.
* Delete database file (perkamkopa.sql.gz) from root directory.
* Configure database variables in the /config/database.php file.
* Configure app variables in the /config/app.php file (disable debug).

## Comments

For safety CHMOD should be set to 644 for directories and subdirectories:
* /app/
* /bootstrap/
* /config/
* /views/

You can choose to put non-public directories outside servers public_html directory, but then some 
additional path configuration is required. Contact author for assistance.

Some scenarios are not tested. For example:
* What happens if session is disrupted / manipulated
* What happens if answers or questions are created / deleted from database
* Form resubmission for same question
* ect.

## TODO

* Database connection should be moved from BaseController to BaseModel (injected elsewhere)

## Author

Janis Galejs