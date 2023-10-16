# COMP333_HW2
COMP333 - Adding in backend databases to practice working with user data and the LAMP stack

Sydney Keller (<smkeller@wesleyan.edu>)
Minji Woo (<mwoo@wesleyan.edu>)

## Purpose:
Designing and implementing a relational database scheme using the MySQL database language. Based on the LAMP stack, designing and implementing a CRUD web app gluing a MySQL database to an HTML frontend via PHP. Learning how to set up development and production environments as well as deploying a web app.

## Setting up the developement environment:
Screenshot of local XAMPP developement environment
</br><img align ="center"
height="32%"
width="32%"
src="./Images/Sydney_XAMPP.png"
alt="Screenshot of local XAMPP developement environment"
/>

Screenshot of user table structure
</br><img align ="center"
height="32%"
width="32%"
src="./Images/Sydney_user_table_structure.png"
alt="Screenshot of user_table structure"
/>

Screenshot of user table data
</br><img align ="center"
height="32%"
width="32%"
src="./Images/Sydney_user_table.png"
alt="Screenshot of user_table"
/>

Screenshot of ratings table structure
</br><img align ="center"
height="32%"
width="32%"
src="./Images/Sydney_ratings_table_structure.png"
alt="Screenshot of ratings_table structure"
/>

Screenshot of ratings table data
</br><img align ="center"
height="32%"
width="32%"
src="./Images/Sydney_ratings_table.png"
alt="Screenshot of ratings_table"
/>

## How to run the code:
Locally in a browser using XAMPP localhost URL (need to have the proper mySQL databases set up)

# Files:
index.php - main homepage for rating web app
login.php - login page for current users
signup.php - signup page for new users
add_new_song.php - page for users to add a new song and rating to the datatable
logout.php - logs out current user by destroying session and takes user back to login page
delete.php - prompts user to make sure they want to delete given song, then if yes, deletes it (only can be done with the users data, no one else)
update.php - updates song, artist, and/or rating for user (only can be done with the users data, no one else)
view.php - displays a clean page of a given rating including song, artist, rating, and username of rater
Sydney_XAMPP - Screenshot of local XAMPP developement environment
Sydney_user_table_structure.png - Screenshot of user_table structure from phpMyAdmin
Sydney_user_table.png - Screenshot of user_table from phpMyAdmin
Sydney_ratings_table_structure.png - Screenshot of ratings_table structure from phpMyAdmin
Sydney_ratings_table.png - Screenshot of ratings_table from phpMyAdmin

# Sources Cites:
https://www.geeksforgeeks.org/how-to-use-php-in-html/ - general understanding of integrating php and html
https://stackoverflow.com/questions/7467330/php-headerlocation-force-url-change-in-address-bar - how to use headers to redirect users once logged in
https://www.hostinger.com/tutorials/how-to-use-php-to-insert-data-into-mysql-database - how to insert data into SQL database for signup page
https://stackoverflow.com/questions/21267064/mysql-database-wont-start-in-xampp-manager-osx#:~:text=It%20can%20cause%20because%20of,so%20it%20was%20not%20working - my xampp stopped being able to run mySQL database because the port was taken, used this forum to figure out how to fix
https://www.w3schools.com/php/php_mysql_select.asp - display ratings table on main page
https://stackoverflow.com/questions/13624276/how-to-separate-table-rows-with-a-line - formatting main table on index.php using html
https://docs.github.com/en/pull-requests/committing-changes-to-your-project/creating-and-editing-commits/changing-a-commit-message - needed to learn how to change commit message
https://stackoverflow.com/questions/6472123/why-is-php-session-destroy-not-working - could not figure out why session_destroy() wasn’t working
https://www.geeksforgeeks.org/php-strlen-function/ - make sure password is at least 10 char long