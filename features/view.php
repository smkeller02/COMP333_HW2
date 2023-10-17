<!--
    COMP333: Software Engineering

    Sydney Keller (smkeller@wesleyan.edu)
    Minji Woo (mwoo@wesleyan.edu)
-->
<?php
    // Start session
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
        <meta name="description" content="Music rating web app view a single song rating page"/>

        <title>MusicUnited View Rating</title>

    </head>

    <body>
        <!-- Logged in message -->
        <p style="text-align: left;">
            You are logged in as user: 
            <?php 
                echo $_SESSION['username']; 
            ?>
            <br><a href="../signup,login,out/logout.php">Log Out</a>
        </p>

        <h1>
            View Rating
        </h1>

        <?php 
            $servername = "sql313.infinityfree.com";
            $username = "if0_35135068";
            $password = "WQFLcEyVvOrKu";
            $dbname = "if0_35135068_music_db";

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
                
                // Fetch result from statement and then echo out results, else show error
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
        
            // Close SQL connection.
            $conn->close();
        ?>

        <p>
            <a href="../index.php">Back</a>
        </p>

    </body>
</html>