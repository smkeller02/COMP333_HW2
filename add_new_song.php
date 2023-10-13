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
                $s_username = $_SESSION['username'];
                $s_artist = $_REQUEST['artist'];
                $s_song = $_REQUEST['song'];
                $s_rating = $_REQUEST['rating'];

                // Check that the user entered data in the form.
                if (!empty($s_artist) && !empty($s_song)) {
                    if ($s_rating <= 5 && $s_rating >= 1 && is_numeric($s_rating)) { //Checking for invalid rating type
                        $stmt = mysqli_prepare($conn, "SELECT username, artist, song FROM ratings WHERE username = ? AND artist = ? AND song = ?");
                
                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, "sss", $s_username, $s_artist, $s_song);
                            mysqli_stmt_execute($stmt);
                            // Get result and check if user rated song already
                            mysqli_stmt_store_result($stmt);
                            $row_num = mysqli_stmt_num_rows($stmt);

                            if ($row_num > 0) { //Checking if user rated song already
                                $out_value = "Error: You have already rated this song. To change your rating navigate to the main page and click update next to the desired song.";
                            } else {
                                //If user hasn't, add data into table
                                $stmt2 = mysqli_prepare($conn, "INSERT INTO ratings (username, artist, song, rating) VALUES (?, ?, ?, ?)");
                                if ($stmt2) {
                                    mysqli_stmt_bind_param($stmt2, "sssi", $s_username, $s_artist, $s_song, $s_rating);
                                    // insert in database 
                                    $result = mysqli_stmt_execute($stmt2);
                                    if ($result) {                        
                                        header("Location: index.php");
                                    } else {
                                        $out_value = "Error: " . $conn->error;
                                    }
                                    // Close statement
                                    mysqli_stmt_close($stmt2);
                                } else {
                                $out_value = "Error: could not execute prepared statement ";
                                }
                            }
                            // Close statement
                            mysqli_stmt_close($stmt);
                        } else {
                            $out_value = "Error: Could not execute prepared statement ";
                        }
                    } else {
                        $out_value = "Error: Rating must be between 1 and 5.";
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
    