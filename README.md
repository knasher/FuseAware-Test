#Scraper Test

##Installing

This project only requires PHPUnit in a dev environment and can be run in production without any other dependencies. To
install PHPUnit simply run the following command:

$ composer install

If you do not have composer it can be downloaded here: https://getcomposer.org/download/

##Running

To run the script just cd into the root directory and run the following command:

$ php ./scraper.php [FILENAME] -u|--url=[DIFFERENT_URL]

[FILENAME] is the location and name of the file you want to create.
[DIFFERENT_URL] is provided if you want to run the Scraper against a different URL from the default of
http://www.black-ink.org.

##Running the tests

The codebase has been written to be completely testable, due to time constraints I haven't had time to add all the
testing I would usually do, a few simple tests have been added for the ArticleMatch class and can be run by using the
following command:

$ php vendor/bin/phpunit test
