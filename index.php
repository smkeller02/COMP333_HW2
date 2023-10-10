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
        <p style="text-align: right;">
            User: 
            <?php 
                echo $_SESSION['username']; 
            ?>
            </br><a href="logout.php">Log Out</a>
        </p>

        <h2>
            Ratings Table:
        </h2>

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

            //display ratings_table
            $sql_query = "SELECT artist, song, rating FROM ratings_table";
            $result = mysqli_query($conn, $sql_query);

            if (mysqli_num_rows($result) > 0) {
                echo "<table border=1px><tr><th>Artist</th><th>Song</th><th>Rating</th></tr>";
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row["artist"]. "</td><td>" . $row['song'] . "</td><td>" . $row['rating'] . "</td></tr>";
            }
                echo "</table>";
            } else {
                echo "Nothing in database";
            }
        ?>


        <p>
            <a href="add_new_song.php">Add new song rating</a>
        </p>

    </body>

</html>
