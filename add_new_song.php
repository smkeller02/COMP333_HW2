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

        <title>MusicUnited Add New Song Page</title>

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


        <h1>
            Enter your new song + rating below:
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

            if(isset($_REQUEST["submit"])){
                // Variables for the output and the web form below.
                $out_value = "";
                $s_artist = $_REQUEST['artist'];
                $s_song = $_REQUEST['song'];
                $s_rating = $_REQUEST['rating'];

                // Check that the user entered data in the form.
                if (!empty($s_artist) && !empty($s_song) && !empty($s_rating)) {

                    // add data into table
                    $sql_query = "INSERT INTO ratings_table (username, artist, song, rating) VALUES ('$s_username', '$s_artist', '$s_song', '$s_rating')";
                        // insert in database 
                        $result = mysqli_query($conn, $sql_query);

                        if ($result) {                        
                            header("Location: index.php");
                        } else {
                            echo "Error: " . $conn->error;
                        }

            } else {
                $out_value = "Error: Not all fields filled out";
            }

            // Close SQL connection.
            $conn->close();
            }
    ?>

     <!-- HTML form -->
     <form method="GET" action="">
            Artist: <input type="text" name="artist" placeholder="Enter the artist" /><br>
            Song: <input type="text" name="song" placeholder="Enter the song title" /><br>
            Rating (must be an integer 1-5): <input type="text" name="rating" placeholder="Enter your rating" /><br>
            <input type="submit" name="submit" value="Add"/>
            <!--
            Make sure that there is a value available for $out_value.
            If so, print to the screen.
            -->
            <p><?php 
                if(!empty($out_value)){
                    echo $out_value;
                }
            ?></p>
    </form>

    <p>
        <a href="index.php">cancel</a>
    </p>

    </body>
</html>
    