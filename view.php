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

        <title>MusicUnited View Rating</title>

        <!-- Linking CSS style sheet -->
        <link rel="stylesheet" href="style_sheet.css" />

    </head>

    <body>
        <p style="text-align: left;">
            You are logged in as user: 
            <?php 
                echo $_SESSION['username']; 
            ?>
            </br><a href="logout.php">Log Out</a>
        </p>

        <h1>
            View Rating
        </h1>

        <?php 
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

            $s_id = $_REQUEST['id'];

            // Parametricize and prepare statment
            $stmt = mysqli_prepare($conn, "SELECT username, artist, song, rating FROM ratings WHERE id =?");

            if ($stmt) {
                // Execute prepared query and bind output of prepared statement to variables
                mysqli_stmt_bind_param($stmt, "i", $s_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $username, $artist, $song, $rating);
                
                if (mysqli_stmt_fetch($stmt)) {
                    echo "<p>Username</br></br> <strong>$username</strong></p>";
                    echo "<p>Artist</br></br> <strong>$artist</strong></p>";
                    echo "<p>Song</br></br> <strong>$song</strong></p>";
                    echo "<p>Rating</br></br> <strong>$rating</strong></p>";
                } else {
                    echo "No data found for ID: $s_id";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: Could not execute prepared statekemtn ";
            }
        ?>

        <p>
            <a href="index.php">Back</a>
        </p>

    </body>
</html>