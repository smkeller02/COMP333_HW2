<!--
    COMP333: Software Engineering

    Sydney Keller (smkeller@wesleyan.edu)
    Minji Woo (mwoo@wesleyan.edu)
-->
<?php
    session_start();
?>
<!DOCTYPE html>

<!-- Setting the language -->
<html lang='en'>

    <!-- Basic info about page for browser, not displayed on website -->
    <head>
        <!-- Help the browser understand what characters to render by
            specifying a character set -->
        <meta charset="utf-8" />

        <!-- Setting viewport to be accessible on mobile and desktop -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Summary describing content on website for brower to use -->
        <meta name="description" content="Music rating web app log-in/rating page"/>

        <title>MusicUnited Main Ratings Page</title>

        <!-- Linking CSS style sheet -->
        <link rel="stylesheet" href="style_sheet.css" />

    </head>

    <body>
        <p>
            User: 
                <?php
                echo $_SESSION['username']; 
                ?>
            </br><a href="logout.php">Log Out</a>
        </p>

        <h2>
            Song Ratings:
        </h2>

        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1); 
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "music_db";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Parametricize and prepare statment
            $stmt = mysqli_prepare($conn, "SELECT id, username, artist, song, rating FROM ratings");

            if ($stmt) {
                mysqli_stmt_execute($stmt);
                // Execute prepared query and bind output of prepared statement to variables
                mysqli_stmt_bind_result($stmt, $id, $username, $artist, $song, $rating);
                // Create table
                echo "<table border=1px>";
                echo "<tr><th>ID</th><th>Username</th><th>Artist</th><th>Song</th><th>Rating</th></tr>";
                while (mysqli_stmt_fetch($stmt)) {
                    echo "<tr><td>$id</td><td>$username</td><td>$artist</td><td>$song</td><td>$rating</td></tr>";
                }
                echo "</table>";
                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: Could not execute prepared statement";
            }
        // Close SQL connection.
        $conn->close();
        ?>

        <p>
            <a href="add_new_song.php">Add new song rating</a>
        </p>

    </body>

</html>
